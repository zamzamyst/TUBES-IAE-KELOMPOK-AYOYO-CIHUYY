# GraphQL Schema Documentation

Complete documentation of the GraphQL schema for the PAW-KELOMPOK7-SI4710 food ordering and delivery system.

## Overview

This GraphQL schema provides a complete API for managing:
- Users and authentication
- Food menus
- Customer orders
- Deliveries and tracking
- Customer feedback
- Delivery services

---

## Types

### User
Represents an authenticated user in the system.

**Fields:**
- `id: ID!` - Unique user identifier
- `name: String!` - User's full name
- `email: String!` - User's email address
- `email_verified_at: String` - Email verification timestamp

### Menu
Represents a food item or menu option.

**Fields:**
- `id: ID!` - Unique menu identifier
- `menu_code: String!` - Unique menu code
- `name: String!` - Menu item name
- `price: Float!` - Price in currency
- `description: String!` - Item description

### Order
Represents a customer order.

**Fields:**
- `id: ID!` - Unique order identifier
- `menu_code: String!` - Code of the ordered menu item
- `name: String!` - Name of the ordered item
- `price: Float!` - Price of the item
- `quantity: Int!` - Quantity ordered
- `notes: String` - Special notes or instructions
- `delivery: Delivery` - Associated delivery information
- `feedback: Feedback` - Associated customer feedback

### Delivery
Represents order delivery information.

**Fields:**
- `id: ID!` - Unique delivery identifier
- `order_id: Int!` - Associated order ID
- `delivery_service_id: Int!` - Delivery service provider ID
- `delivery_address: String!` - Delivery address
- `delivery_status: DeliveryStatus!` - Current delivery status
- `order: Order!` - Related order
- `deliveryService: DeliveryService!` - Delivery service provider
- `tracking: Tracking` - Real-time tracking information

### DeliveryService
Represents a delivery service provider.

**Fields:**
- `id: ID!` - Unique service identifier
- `name: String!` - Service provider name
- `price: Float!` - Delivery service price
- `estimation_days: Int!` - Estimated delivery days
- `is_active: Boolean!` - Whether service is active

### Tracking
Represents real-time delivery tracking information.

**Fields:**
- `id: ID!` - Unique tracking record ID
- `delivery_id: Int!` - Associated delivery ID
- `latitude: Float!` - Current latitude coordinate
- `longitude: Float!` - Current longitude coordinate
- `delivery: Delivery!` - Related delivery

### DeliveryStatus
Enumeration for delivery status.

**Values:**
- `pending` - Delivery is pending
- `in_transit` - Delivery is in transit
- `delivered` - Delivery completed
- `cancelled` - Delivery cancelled

---

## Root Queries

The Query type provides read-only access to data.

### User Queries
- `user(id: ID!)` - Get a single user by ID
- `users` - Get all users

### Menu Queries
- `menu(id: ID!)` - Get a single menu by ID
- `menus` - Get all menus
- `menuByCode(code: String!)` - Get menu by code

### Order Queries
- `order(id: ID!)` - Get a single order by ID
- `orders` - Get all orders
- `ordersByUser(user_id: ID!)` - Get orders for a specific user

### Delivery Queries
- `delivery(id: ID!)` - Get a single delivery by ID
- `deliveries` - Get all deliveries
- `deliveriesByStatus(status: DeliveryStatus!)` - Get deliveries filtered by status
- `deliveriesByOrder(order_id: ID!)` - Get deliveries for a specific order

### Tracking Queries
- `tracking(id: ID!)` - Get a single tracking record by ID
- `trackings` - Get all tracking records
- `trackingByDelivery(delivery_id: ID!)` - Get tracking for a delivery

### Delivery Service Queries
- `deliveryService(id: ID!)` - Get a single delivery service by ID
- `deliveryServices` - Get all delivery services
- `activeDeliveryServices(is_active: Boolean!)` - Get active delivery services

---

## Root Mutations

The Mutation type provides write operations (create, update, delete).

### Menu Mutations
- `createMenu(menu_code, name, price, description)` - Create a new menu item
- `updateMenu(id, menu_code, name, price, description)` - Update a menu item
- `deleteMenu(id)` - Delete a menu item

### Order Mutations
- `createOrder(menu_code, quantity, notes)` - Create a new order
- `updateOrder(id, notes)` - Update an order
- `deleteOrder(id)` - Delete an order

### Delivery Mutations
- `createDelivery(order_id, delivery_service_id, delivery_address, delivery_status)` - Create delivery record
- `updateDelivery(id, delivery_service_id, delivery_address, delivery_status)` - Update delivery
- `deleteDelivery(id)` - Delete delivery

### Tracking Mutations
- `createTracking(delivery_id, latitude, longitude)` - Create tracking record
- `updateTracking(id, latitude, longitude)` - Update tracking location
- `updateTrackingByDelivery(delivery_id, latitude, longitude)` - Update tracking by delivery ID
- `deleteTracking(id)` - Delete tracking record

### Delivery Service Mutations
- `createDeliveryService(name, price, estimation_days, is_active)` - Create delivery service
- `updateDeliveryService(id, name, price, estimation_days, is_active)` - Update service
- `deleteDeliveryService(id)` - Delete service

---

For usage examples, please read the `GraphQL Testing Guide`
___

## 📚 Documentation

- [GraphQL Detail Schema](GRAPHQL_SCHEMA_DOCUMENTATION.md) - Detail skema GraphQL
- [GraphQL Testing Guide](GRAPHQL_TESTING_GUIDE.md) - Cara menggunakan GraphQL Playground

<p align="right">(<a href="#readme-top">back to top</a>)</p>

---

## Notes

- All ID fields are required and immutable
- Timestamp fields (created_at, updated_at) are managed by the system
- DateTime handling uses ISO 8601 format strings
- Relationships are automatically resolved through Lighthouse directives
- All mutations return the modified object for immediate feedback

