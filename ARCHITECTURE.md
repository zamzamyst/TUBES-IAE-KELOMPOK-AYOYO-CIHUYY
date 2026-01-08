# Delivery Service Architecture Diagram

## Module Interaction Overview

```
┌─────────────────────────────────────────────────────────────┐
│                      PROVIDER-CONSUMER MODEL                │
└─────────────────────────────────────────────────────────────┘

                    ┌──────────────────────┐
                    │  DELIVERY PROVIDER   │
                    │   (This Module)      │
                    └──────────────────────┘
                             ▲
                             │ HTTP REST API
                             │ /api/v1/delivery-services
                             │
            ┌────────────────┼────────────────┐
            │                │                │
            ▼                ▼                ▼
    ┌─────────────┐  ┌──────────────┐  ┌─────────────┐
    │ORDER MODULE │  │TRACKING      │  │ FEEDBACK    │
    │(CONSUMER)   │  │MODULE        │  │ MODULE      │
    │             │  │(CONSUMER)    │  │(CONSUMER)   │
    └─────────────┘  └──────────────┘  └─────────────┘
      │ Stores        │ Reads           │ References
      │ snapshot      │ estimates       │ service info
      │ data          │                 │
```

---

## Request-Response Flow

### Public Read Endpoint

```
Consumer Module
    │
    ├─ HTTP GET /api/v1/delivery-services
    │
    └─────────────────────────────────────┬──────────┐
                                          │          │
                                    Provider API      │
                                    Controller        │
                                          │          │
                                          ├──────────┘
                                          │
                                          ├─ Auth Check (None Required)
                                          │
                                          ├─ DeliveryService::active()
                                          │
                                          ├─ DeliveryServiceCollection
                                          │
                                          ├─ Return JSON
                                          │
    ┌──────────────────────────────────────┘
    │
    ▼
Response:
{
  "data": [
    {
      "id": 1,
      "name": "Regular",
      "price": 20000,
      "estimation_days": 5,
      "is_active": true
    },
    ...
  ],
  "meta": { "total": 2 }
}
```

### Protected CRUD Endpoint

```
Consumer Module (Admin User)
    │
    ├─ HTTP POST /api/v1/delivery-services
    ├─ Authorization: Bearer {token}
    ├─ Content-Type: application/json
    │
    └──────────────┬──────────────────┐
                   │                  │
               Provider API           │
               Controller             │
                   │                  │
                   ├──────────────────┘
                   │
                   ├─ Check auth()->check()
                   │
                   ├─ Check permission: manage_delivery_services
                   │   └─ If false → 403 Unauthorized
                   │
                   ├─ Validate Request
                   │   └─ If invalid → 422 Unprocessable
                   │
                   ├─ DeliveryService::create()
                   │
                   ├─ DeliveryServiceResource
                   │
                   ├─ Return 201 Created
                   │
    ┌──────────────┘
    │
    ▼
Response:
{
  "id": 5,
  "name": "Premium",
  "price": 100000,
  "estimation_days": 1,
  "is_active": true,
  "created_at": "2025-12-18T10:30:00Z",
  "updated_at": "2025-12-18T10:30:00Z"
}
```

---

## Data Flow: Order Creation with Delivery Service

```
┌─────────────────────────────────────────────────────────────────┐
│                    ORDER CREATION FLOW                          │
└─────────────────────────────────────────────────────────────────┘

Step 1: User selects Order & Delivery Service
    │
    ▼
Step 2: OrderController::create()
    │
    ├─ GET /api/v1/delivery-services (From Delivery Provider)
    │
    └─ Display form with delivery options
    │
Step 3: User submits order form
    │
    ├─ Selected delivery_service_id: 2
    │
Step 4: OrderController::store()
    │
    ├─ Validate delivery_service_id
    │
    ├─ GET /api/v1/delivery-services/2 (Verify exists)
    │       └─ Response: { id: 2, name: "Express", price: 50000, estimation_days: 2 }
    │
    ├─ Store Order with SNAPSHOT:
    │   ├─ order.menu_id .................. [Menu ID]
    │   ├─ order.quantity ................ [Quantity]
    │   ├─ order.delivery_service_id ..... [2] (Provider ID)
    │   ├─ order.delivery_service_name ... ["Express"] (Snapshot)
    │   ├─ order.delivery_cost .......... [50000] (Snapshot)
    │   └─ order.delivery_estimation .... [2] (Snapshot)
    │
    ▼
Order Created ✓
    │
    └─ Even if Delivery Provider later changes the price
       Order keeps historical data: 50000

Why Snapshot?
✓ Price guarantees: Customer sees locked-in price
✓ Audit trail: Know what price was when order created
✓ Independence: Works even if provider is down
✓ No direct access: Consumer doesn't need provider DB
```

---

## Database Schema Relationship

```
┌─────────────────────────────────────┐
│       delivery_services (Provider)  │  ← Owned by Provider
├─────────────────────────────────────┤
│ id          (PK)                    │
│ name        (unique)                │
│ price       (decimal)               │
│ estimation_days (int)               │
│ is_active   (boolean)               │
│ created_at                          │
│ updated_at                          │
└─────────────────────────────────────┘
           △
           │
           │ Reference (ID only)
           │
           │ Snapshot (name, price, estimation)
           │
           ▽
┌─────────────────────────────────────┐
│       orders (Consumer)             │  ← Owned by Consumer
├─────────────────────────────────────┤
│ id                  (PK)            │
│ menu_id             (FK)            │
│ quantity                            │
│ delivery_service_id ✓ (Store ID)    │
│ delivery_service_name ✓ (Snapshot)  │
│ delivery_cost ✓ (Snapshot)          │
│ delivery_estimation ✓ (Snapshot)    │
│ created_at                          │
│ updated_at                          │
└─────────────────────────────────────┘

NO FOREIGN KEY to delivery_services!
Consumer NEVER directly queries Provider DB
```

---

## API Route Structure

```
routes/api.php
│
├─ VERSIONED ROUTES (v1)
│  │
│  └─ Route::prefix('api/v1')
│     │
│     ├─ GET /delivery-services
│     │  └─ DeliveryServiceController::index() [PUBLIC]
│     │
│     ├─ GET /delivery-services/:id
│     │  └─ DeliveryServiceController::show() [PUBLIC]
│     │
│     ├─ POST /delivery-services
│     │  └─ DeliveryServiceController::store() [PROTECTED]
│     │
│     ├─ PUT /delivery-services/:id
│     │  └─ DeliveryServiceController::update() [PROTECTED]
│     │
│     └─ DELETE /delivery-services/:id
│        └─ DeliveryServiceController::destroy() [PROTECTED]
│
└─ LEGACY ROUTES (v0 - Backward Compatible)
   │
   └─ Route::prefix('api')
      │
      ├─ GET /delivery (Old DeliveryController)
      ├─ GET /delivery/:id
      ├─ POST /delivery
      ├─ PUT /delivery/:id
      └─ DELETE /delivery/:id
```

---

## Permission & Role Matrix

```
┌──────────────────────────────────────────────────────────┐
│          PERMISSION: manage_delivery_services            │
├──────────────────────────────────────────────────────────┤
│                                                          │
│  Can perform on endpoints:                              │
│  • POST   /api/v1/delivery-services      ✓ Create       │
│  • PUT    /api/v1/delivery-services/:id  ✓ Update       │
│  • DELETE /api/v1/delivery-services/:id  ✓ Delete       │
│                                                          │
│  Cannot perform (Forbidden 403):                        │
│  • Any protected endpoint without this permission       │
│                                                          │
└──────────────────────────────────────────────────────────┘

┌─────────────────────────────────────┐
│      ROLE: admin                    │
├─────────────────────────────────────┤
│ Has permission:                     │
│ • manage_delivery_services ✓        │
│                                     │
│ Can:                                │
│ ✓ Create delivery services          │
│ ✓ Update delivery services          │
│ ✓ Delete delivery services          │
│ ✓ View all services (public)        │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│      ROLE: seller                   │
├─────────────────────────────────────┤
│ Has permission:                     │
│ • manage_delivery_services ✗        │
│                                     │
│ Can:                                │
│ ✓ View active services (public)     │
│ ✗ Cannot create/update/delete       │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│      ROLE: customer                 │
├─────────────────────────────────────┤
│ Has permission:                     │
│ • manage_delivery_services ✗        │
│                                     │
│ Can:                                │
│ ✓ View active services (public)     │
│ ✗ Cannot create/update/delete       │
└─────────────────────────────────────┘
```

---

## Controller Logic Flow

```
DeliveryServiceController::store()
│
├─ Receive HTTP Request
│  └─ POST /api/v1/delivery-services
│     ├─ Headers: Authorization: Bearer {token}
│     └─ Body: { name, price, estimation_days, is_active }
│
├─ STEP 1: Authenticate
│  └─ if (!auth()->check()) return 403
│
├─ STEP 2: Authorize
│  └─ if (!auth()->user()->hasPermissionTo('manage_delivery_services'))
│     return 403
│
├─ STEP 3: Validate
│  └─ $validated = $request->validate([
│     'name' => 'required|string|unique:delivery_services',
│     'price' => 'required|numeric|min:0',
│     'estimation_days' => 'required|integer|min:1',
│     'is_active' => 'boolean',
│  ])
│  └─ If invalid: return 422 with errors
│
├─ STEP 4: Create
│  └─ $service = DeliveryService::create($validated)
│
├─ STEP 5: Transform
│  └─ $resource = new DeliveryServiceResource($service)
│
└─ STEP 6: Response
   └─ return response()->json($resource, 201)
```

---

## Error Handling Flow

```
┌─────────────────────────────────────────────────┐
│         API Request                             │
└─────────────────────────────────────────────────┘
            │
            ▼
    ┌───────────────────┐
    │ Authenticate?     │
    └───────────────────┘
         │        │
        NO       YES
         │        │
    403  ▼        │
   UNAUTH       │
         │       ▼
         │   ┌────────────────┐
         │   │ Authorize?     │
         │   │ (Permission?)  │
         │   └────────────────┘
         │        │        │
         │       NO       YES
         │        │        │
         │    403 ▼        │
         │   FORBIDDEN    │
         │        │       ▼
         │        │   ┌─────────────┐
         │        │   │ Validate?   │
         │        │   └─────────────┘
         │        │        │        │
         │        │       NO       YES
         │        │        │        │
         │        │    422 ▼        │
         │        │ UNPROCESS      │
         │        │        │       ▼
         │        │        │   ┌──────────┐
         │        │        │   │ Execute  │
         │        │        │   │ Logic    │
         │        │        │   └──────────┘
         │        │        │       │
         │        │        │   SUCCESS
         │        │        │   (200, 201)
         │        │        │       │
         └────────┴────────┴───────┬─────────────────┐
                                   │                 │
                                   ▼                 ▼
                          ┌─────────────┐   ┌──────────────┐
                          │   Return    │   │ Return Error │
                          │   JSON      │   │ JSON         │
                          └─────────────┘   └──────────────┘
```

---

## File Organization

```
app/
├── Models/
│   ├── DeliveryService.php ............. ✨ NEW
│   ├── Delivery.php ................... (Legacy, unchanged)
│   ├── Order.php ...................... (Consumer)
│   └── Tracking.php ................... (Consumer)
│
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── V1/ ..................... ✨ NEW
│   │   │   │   └── DeliveryServiceController.php (Provider)
│   │   │   ├── DeliveryController.php .. (Legacy)
│   │   │   ├── MenuController.php ...... (Provider)
│   │   │   ├── OrderController.php ..... (Consumer)
│   │   │   └── TrackingController.php .. (Consumer)
│   │   ├── DeliveryController.php ...... (Web UI)
│   │   ├── OrderController.php ......... (Web UI)
│   │   └── TrackingController.php ...... (Web UI)
│   │
│   └── Resources/
│       ├── DeliveryServiceResource.php ........... ✨ NEW
│       ├── DeliveryServiceCollection.php ........ ✨ NEW
│       └── (Other resources)
│
└── Services/
    ├── DeliveryServiceConsumer.php ........... ✨ NEW (Helper)
    └── (Other services)

database/
├── migrations/
│   ├── 2025_12_18_000000_create_delivery_services_table.php ✨ NEW
│   └── (Other migrations)
│
└── seeders/
    ├── DeliveryServiceSeeder.php ............ ✨ NEW
    ├── RolePermissionSeeder.php ............ (Updated)
    └── (Other seeders)

routes/
└── api.php (Updated)

Documentation/
├── DELIVERY_SERVICE_API.md ............... ✨ NEW
├── REFACTORING_SUMMARY.md ............... ✨ NEW
├── IMPLEMENTATION_GUIDE.md .............. ✨ NEW
├── IMPLEMENTATION_CHECKLIST.md .......... ✨ NEW
└── ARCHITECTURE.md ...................... ✨ NEW (This file)
```

---

## Key Principles Visualization

```
┌─────────────────────────────────────────────────────────────┐
│           PROVIDER-CONSUMER ARCHITECTURE                   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ PRINCIPLE 1: SEPARATION OF CONCERNS              │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ Provider: OWNS DeliveryService model             │   │
│  │ Consumer: REFERENCES via API only                 │   │
│  │ Result: Independent, testable modules            │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ PRINCIPLE 2: HTTP AS COMMUNICATION                │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ No direct DB access                              │   │
│  │ No model imports across modules                   │   │
│  │ REST API is the contract                          │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ PRINCIPLE 3: SNAPSHOT DATA PATTERN                │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ Consumer stores provider data at transaction time  │   │
│  │ Ensures historical consistency                    │   │
│  │ Prevents tight coupling                           │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ PRINCIPLE 4: PERMISSION-BASED ACCESS              │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ Public: Read endpoints (no auth)                  │   │
│  │ Protected: Write endpoints (permission required)  │   │
│  │ Granular: manage_delivery_services permission    │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─────────────────────────────────────────────────────┐   │
│  │ PRINCIPLE 5: VERSIONED APIS                       │   │
│  ├─────────────────────────────────────────────────────┤   │
│  │ /api/v1 for new endpoints                        │   │
│  │ /api for legacy (backward compatibility)         │   │
│  │ Easy future migrations                            │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

This architecture ensures:
✅ Clear responsibility boundaries
✅ Independent scaling and deployment
✅ Loose coupling with HTTP interfaces
✅ Permission-based security model
✅ Historical data integrity through snapshots
✅ Future-proof versioned APIs
