# GraphQL Testing Guide

Your GraphQL API is now fully set up and ready for testing!

## 🎮 Quick Access

### GraphQL Playground (Visual IDE)
Open in your browser:
```
http://127.0.0.1:8000/graphql-playground
```

This provides an interactive interface to:
- Write and execute GraphQL queries
- View schema documentation
- See real-time results
- Test mutations

### GraphQL Endpoint (API)
Direct endpoint for requests:
```
POST http://127.0.0.1:8000/graphql
Content-Type: application/json
```

---

## 📝 Example Queries

### Query 1: Get All Menus
```graphql
{
  menus {
    id
    menu_code
    name
    description
    price
  }
}
```

### Query 2: Get Single Menu by ID
```graphql
{
  menu(id: 1) {
    id
    menu_code
    name
    description
    price
  }
}
```

### Query 3: Get All Orders
```graphql
{
  orders {
    id
    menu_code
    name
    price
    quantity
    notes
    created_at
  }
}
```

### Query 4: Get User
```graphql
{
  user(id: 1) {
    id
    name
    email
  }
}
```

---

## ✏️ Example Mutations

### MENU CRUD Operations

#### Create Menu
```graphql
mutation {
  createMenu(
    menu_code: "MENU001"
    name: "Nasi Goreng"
    description: "Fried rice with chicken and egg"
    price: 25000
  ) {
    id
    menu_code
    name
    price
    created_at
  }
}
```

#### Read Menu (Query)
```graphql
{
  menu(id: 1) {
    id
    menu_code
    name
    description
    price
  }
}
```

#### Update Menu
```graphql
mutation {
  updateMenu(
    id: 1
    name: "Nasi Goreng Spesial"
    price: 30000
  ) {
    id
    name
    price
    updated_at
  }
}
```

#### Delete Menu
```graphql
mutation {
  deleteMenu(id: 1)
}
```

---

### ORDER CRUD Operations

#### Create Order
```graphql
mutation {
  createOrder(
    menu_code: "MENU001"
    name: "Nasi Goreng"
    price: 25000
    quantity: 2
    notes: "No spicy"
  ) {
    id
    menu_code
    name
    price
    quantity
    notes
    created_at
  }
}
```

#### Read Order (Query)
```graphql
{
  order(id: 1) {
    id
    menu_code
    name
    price
    quantity
    notes
  }
}
```

#### Update Order
```graphql
mutation {
  updateOrder(
    id: 1
    name: "Nasi Goreng Bumbu Ekstra"
    price: 28000
    quantity: 3
    notes: "Extra spicy"
  ) {
    id
    name
    price
    quantity
    notes
    updated_at
  }
}
```

#### Delete Order
```graphql
mutation {
  deleteOrder(id: 1)
}
```

---

### DELIVERY CRUD Operations

#### Create Delivery
```graphql
mutation {
  createDelivery(
    order_id: 1
    delivery_service_id: 1
    delivery_address: "Jl. Merdeka No. 123, Jakarta"
    delivery_status: pending
  ) {
    id
    order_id
    delivery_address
    delivery_status
    created_at
  }
}
```

#### Read Delivery (Query)
```graphql
{
  delivery(id: 1) {
    id
    order_id
    delivery_address
    delivery_status
  }
}
```

#### Update Delivery
```graphql
mutation {
  updateDelivery(
    id: 1
    delivery_address: "Jl. Sudirman No. 456, Jakarta"
    delivery_status: in_transit
  ) {
    id
    delivery_address
    delivery_status
    updated_at
  }
}
```

#### Delete Delivery
```graphql
mutation {
  deleteDelivery(id: 1)
}
```

---

### TRACKING CRUD Operations

#### Create Tracking
```graphql
mutation {
  createTracking(
    delivery_id: 1
    latitude: -6.2088
    longitude: 106.8456
  ) {
    id
    delivery_id
    latitude
    longitude
    created_at
  }
}
```

#### Read Tracking (Query)
```graphql
{
  tracking(id: 1) {
    id
    delivery_id
    latitude
    longitude
  }
}
```

#### Update Tracking
```graphql
mutation {
  updateTracking(
    id: 1
    latitude: -6.2100
    longitude: 106.8500
  ) {
    id
    delivery_id
    latitude
    longitude
    updated_at
  }
}
```

#### Delete Tracking
```graphql
mutation {
  deleteTracking(id: 1)
}
```

---

### FEEDBACK CRUD Operations

#### Create Feedback
```graphql
mutation {
  createFeedback(
    order_id: 1
    user_id: 1
    rating: 5
    comment: "Excellent service and delicious food!"
  ) {
    id
    order_id
    user_id
    rating
    comment
    created_at
  }
}
```

#### Read Feedback (Query)
```graphql
{
  feedback(id: 1) {
    id
    order_id
    rating
    comment
  }
}
```

#### Update Feedback
```graphql
mutation {
  updateFeedback(
    id: 1
    rating: 4
    comment: "Great food but delivery was a bit late"
  ) {
    id
    order_id
    rating
    comment
    updated_at
  }
}
```

#### Delete Feedback
```graphql
mutation {
  deleteFeedback(id: 1)
}
```

---

### DELIVERY SERVICE CRUD Operations

#### Create Delivery Service
```graphql
mutation {
  createDeliveryService(
    name: "Express Delivery"
    price: 15000
    estimation_days: 1
    is_active: true
  ) {
    id
    name
    price
    estimation_days
    is_active
    created_at
  }
}
```

#### Read Delivery Service (Query)
```graphql
{
  deliveryService(id: 1) {
    id
    name
    price
    estimation_days
    is_active
  }
}
```

#### Update Delivery Service
```graphql
mutation {
  updateDeliveryService(
    id: 1
    price: 18000
    estimation_days: 2
  ) {
    id
    name
    price
    estimation_days
    is_active
    updated_at
  }
}
```

#### Delete Delivery Service
```graphql
mutation {
  deleteDeliveryService(id: 1)
}
```

---

## 🧪 Testing with cURL

### Get Menus (Terminal)
```bash
curl -X POST http://127.0.0.1:8000/graphql \
  -H "Content-Type: application/json" \
  -d '{"query":"{ menus { id menu_code name price } }"}'
```

### Create Menu (Terminal)
```bash
curl -X POST http://127.0.0.1:8000/graphql \
  -H "Content-Type: application/json" \
  -d '{
    "query": "mutation { createMenu(menu_code: \"MENU002\", name: \"Soto Ayam\", description: \"Chicken soup\", price: 20000) { id menu_code name } }"
  }'
```

---

## 🔧 Testing with Postman/Insomnia

1. **Create new request**
   - Method: `POST`
   - URL: `http://127.0.0.1:8000/graphql`

2. **Headers**
   ```
   Content-Type: application/json
   ```

3. **Body (raw, JSON)**
   ```json
   {
     "query": "{ menus { id menu_code name price } }"
   }
   ```

4. **Send** and view results

---

## 📊 Available Queries

From your schema, you have access to:

**Queries:**
- `menu(id)` - Get single menu
- `menus` - Get all menus
- `menuByCode(code)` - Get menu by code
- `order(id)` - Get single order
- `orders` - Get all orders
- `ordersByUser(user_id)` - Get orders by user
- `user(id)` - Get single user
- `users` - Get all users
- `delivery(id)` - Get single delivery
- `deliveries` - Get all deliveries
- `deliveriesByStatus(status)` - Get deliveries by status
- `deliveriesByOrder(order_id)` - Get deliveries for an order
- `tracking(id)` - Get single tracking
- `trackings` - Get all trackings
- `trackingByDelivery(delivery_id)` - Get tracking for delivery
- `feedback(id)` - Get single feedback
- `feedbacks` - Get all feedbacks
- `feedbackByOrder(order_id)` - Get feedback by order
- `feedbacksByRating(rating)` - Get feedbacks by rating
- `deliveryService(id)` - Get single delivery service
- `deliveryServices` - Get all delivery services
- `activeDeliveryServices(is_active)` - Get active delivery services

**Mutations:**
- **Menu:** createMenu, updateMenu, deleteMenu
- **Order:** createOrder, updateOrder, deleteOrder
- **Delivery:** createDelivery, updateDelivery, deleteDelivery
- **Tracking:** createTracking, updateTracking, updateTrackingByDelivery, deleteTracking
- **Feedback:** createFeedback, updateFeedback, deleteFeedback
- **DeliveryService:** createDeliveryService, updateDeliveryService, deleteDeliveryService

---

## 🚀 Next Steps

1. Open GraphQL Playground: http://127.0.0.1:8000/graphql-playground
2. Explore the schema using the **DOCS** panel on the right
3. Try the example queries above
4. Integrate GraphQL client in your frontend application

---

## ⚠️ Important Notes

- Playground is only available in development mode (`APP_DEBUG=true`)
- GraphQL endpoint requires valid queries/mutations
- Authentication may be required for some operations (check directives)
- All queries are logged if `LogGraphQLQueries` middleware is enabled
- Use correct field names: `menu_code` (not `code`)

---

Happy querying! 🎉
