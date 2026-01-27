# Activity Log API Documentation

Complete documentation for the User Activity Log feature using Spatie Activity Log package.

---

## Overview

The Activity Log system automatically tracks all create, update, and delete operations on the following models:
- **Barangs** (Products)
- **Data Stok** (Stock Data)
- **Kategori** (Categories)
- **Pelanggan** (Customers)

All activity logs are linked to the authenticated user who performed the action.

---

## API Endpoints

Base URL: `http://your-domain.com/api`

All endpoints require authentication using Laravel Sanctum token:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

### 1. Get Activity Logs with Date Range

**Endpoint:** `GET /activity-logs`

**Description:** Get paginated activity logs filtered by date range

**Required Parameters:**
- `start_date` (date) - Start date for filtering (format: YYYY-MM-DD or YYYY-MM-DD HH:MM:SS)
- `end_date` (date) - End date for filtering (format: YYYY-MM-DD or YYYY-MM-DD HH:MM:SS)

**Optional Parameters:**
- `per_page` (integer) - Number of records per page (default: 15, max: 100)
- `model_type` (string) - Filter by model type: `barang`, `kategori`, `pelanggan`, `data_stok`

**Usage Example:**
```bash
# Basic request with date range
curl -X GET "http://your-domain.com/api/activity-logs?start_date=2025-01-01&end_date=2025-01-31" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# With pagination
curl -X GET "http://your-domain.com/api/activity-logs?start_date=2025-01-01&end_date=2025-01-31&per_page=25" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# Filter by model type
curl -X GET "http://your-domain.com/api/activity-logs?start_date=2025-01-01&end_date=2025-01-31&model_type=barang" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Example:**
```json
{
  "message": "Activity logs berhasil diambil",
  "filters": {
    "start_date": "2025-01-01 00:00:00",
    "end_date": "2025-01-31 23:59:59",
    "model_type": "all"
  },
  "pagination": {
    "total": 45,
    "per_page": 15,
    "current_page": 1,
    "last_page": 3,
    "from": 1,
    "to": 15
  },
  "data": [
    {
      "id": 123,
      "description": "Barang created",
      "event": "created",
      "subject_type": "barangs",
      "subject_id": 10,
      "causer_id": 1,
      "causer_type": "User",
      "properties": {
        "attributes": {
          "nama_barang": "Laptop ASUS",
          "kode_barang": "LPT001",
          "stok": 10,
          "harga_dasar": "10000000.00",
          "harga_jual": "12000000.00"
        }
      },
      "created_at": "2025-01-24T10:30:15.000000Z"
    },
    {
      "id": 122,
      "description": "Barang updated",
      "event": "updated",
      "subject_type": "barangs",
      "subject_id": 9,
      "causer_id": 1,
      "causer_type": "User",
      "properties": {
        "attributes": {
          "stok": 15,
          "harga_jual": "13000000.00"
        },
        "old": {
          "stok": 10,
          "harga_jual": "12000000.00"
        }
      },
      "created_at": "2025-01-24T09:15:30.000000Z"
    },
    {
      "id": 121,
      "description": "Data Stok created",
      "event": "created",
      "subject_type": "data_stok",
      "subject_id": 5,
      "causer_id": 1,
      "causer_type": "User",
      "properties": {
        "attributes": {
          "id_barangs": 9,
          "stok": 50,
          "harga_dasar": "5000000.00",
          "expired_at": "2025-12-31"
        }
      },
      "created_at": "2025-01-24T08:45:00.000000Z"
    }
  ]
}
```

---

### 2. Get Activity Summary

**Endpoint:** `GET /activity-logs/summary`

**Description:** Get statistical summary of activities within a date range

**Required Parameters:**
- `start_date` (date) - Start date for filtering
- `end_date` (date) - End date for filtering

**Usage Example:**
```bash
curl -X GET "http://your-domain.com/api/activity-logs/summary?start_date=2025-01-01&end_date=2025-01-31" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Example:**
```json
{
  "message": "Activity summary berhasil diambil",
  "period": {
    "start_date": "2025-01-01 00:00:00",
    "end_date": "2025-01-31 23:59:59"
  },
  "summary": {
    "total_activities": 150,
    "by_event": {
      "created": 85,
      "updated": 60,
      "deleted": 5
    },
    "by_model": {
      "barangs": {
        "total": 75,
        "created": 40,
        "updated": 32,
        "deleted": 3
      },
      "data_stok": {
        "total": 50,
        "created": 30,
        "updated": 20,
        "deleted": 0
      },
      "Kategori": {
        "total": 15,
        "created": 10,
        "updated": 5,
        "deleted": 0
      },
      "Pelanggan": {
        "total": 10,
        "created": 5,
        "updated": 3,
        "deleted": 2
      }
    }
  }
}
```

---

### 3. Get Recent Activities

**Endpoint:** `GET /activity-logs/recent`

**Description:** Get recent activities from the last 24 hours

**Optional Parameters:**
- `limit` (integer) - Number of records to return (default: 20)

**Usage Example:**
```bash
# Get last 20 activities
curl -X GET "http://your-domain.com/api/activity-logs/recent" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# Get last 50 activities
curl -X GET "http://your-domain.com/api/activity-logs/recent?limit=50" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response Example:**
```json
{
  "message": "Recent activities berhasil diambil",
  "period": "Last 24 hours",
  "total_records": 12,
  "data": [
    {
      "id": 150,
      "description": "Barang created",
      "event": "created",
      "subject_type": "barangs",
      "subject_id": 15,
      "properties": {
        "attributes": {
          "nama_barang": "Mouse Gaming",
          "kode_barang": "MSE001",
          "stok": 25
        }
      },
      "created_at": "2025-01-24T13:45:30.000000Z",
      "time_ago": "2 hours ago"
    },
    {
      "id": 149,
      "description": "Pelanggan updated",
      "event": "updated",
      "subject_type": "Pelanggan",
      "subject_id": 8,
      "properties": {
        "attributes": {
          "nama_pelanggan": "John Doe Updated",
          "no_pelanggan": "08123456789"
        },
        "old": {
          "nama_pelanggan": "John Doe",
          "no_pelanggan": "08198765432"
        }
      },
      "created_at": "2025-01-24T12:30:15.000000Z",
      "time_ago": "3 hours ago"
    }
  ]
}
```

---

## Properties Structure

The `properties` field in activity logs contains different data based on the event type:

### Created Event
```json
{
  "attributes": {
    "field1": "new_value1",
    "field2": "new_value2"
  }
}
```

### Updated Event
```json
{
  "attributes": {
    "field1": "new_value1",
    "field2": "new_value2"
  },
  "old": {
    "field1": "old_value1",
    "field2": "old_value2"
  }
}
```

### Deleted Event
```json
{
  "attributes": {
    "field1": "deleted_value1",
    "field2": "deleted_value2"
  }
}
```

---

## Logged Fields by Model

### Barangs (Products)
- `nama_barang` (product name)
- `kode_barang` (product code)
- `stok` (stock quantity)
- `harga_dasar` (base price)
- `harga_jual` (selling price)
- `nama_kategori` (category name)
- `tipe_barang` (product type)
- `satuan` (unit)

### Data Stok (Stock Data)
- `id_barangs` (product ID)
- `stok` (stock quantity)
- `harga_dasar` (base price)
- `expired_at` (expiration date)

### Kategori (Categories)
- `nama_kategori` (category name)

### Pelanggan (Customers)
- `nama_pelanggan` (customer name)
- `email_pelanggan` (customer email)
- `no_pelanggan` (customer phone)
- `kode_pelanggan` (customer code)
- `alamat_pelanggan` (customer address)
- `saldo_pelanggan` (customer balance)
- `poin_pelanggan` (customer points)

---

## Error Responses

### 401 Unauthorized
```json
{
  "message": "Unauthorized. Token tidak valid atau tidak ditemukan."
}
```

### 422 Validation Error
```json
{
  "message": "The start date field is required. (and 1 more error)",
  "errors": {
    "start_date": [
      "The start date field is required."
    ],
    "end_date": [
      "The end date field is required."
    ]
  }
}
```

### 422 Date Validation Error
```json
{
  "message": "The end date field must be a date after or equal to start date.",
  "errors": {
    "end_date": [
      "The end date field must be a date after or equal to start date."
    ]
  }
}
```

---

## Usage Tips

1. **Date Format**: Dates can be in `YYYY-MM-DD` or `YYYY-MM-DD HH:MM:SS` format
2. **Timezone**: All timestamps are returned in UTC
3. **Pagination**: Use the pagination metadata to navigate through multiple pages
4. **Model Filter**: Use lowercase model names for filtering (`barang`, `kategori`, `pelanggan`, `data_stok`)
5. **Performance**: Limit date ranges to reasonable periods (e.g., 1-3 months) for better performance

---

## Testing Examples

### Test Activity Creation
1. Create a new product (Barang)
2. Check recent activities - you should see the creation log
3. Update the product
4. Check recent activities - you should see both creation and update logs

### Test Date Range Filtering
```bash
# Get today's activities
curl -X GET "http://your-domain.com/api/activity-logs?start_date=$(date +%Y-%m-%d)&end_date=$(date +%Y-%m-%d)" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# Get this month's activities
curl -X GET "http://your-domain.com/api/activity-logs?start_date=2025-01-01&end_date=2025-01-31" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Test Summary Report
```bash
# Get monthly summary
curl -X GET "http://your-domain.com/api/activity-logs/summary?start_date=2025-01-01&end_date=2025-01-31" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## Integration Notes

1. **Automatic Logging**: All CRUD operations on tracked models are automatically logged
2. **User Attribution**: All logs are automatically associated with the authenticated user
3. **Performance**: Activity logs are stored in a separate table and indexed for quick retrieval
4. **Data Retention**: Consider implementing a cleanup policy for old activity logs
5. **Audit Trail**: Use activity logs for compliance and audit trail requirements

---

## Troubleshooting

### No Activities Logged
- Ensure models have the `LogsActivity` trait
- Verify the model has the `getActivitylogOptions()` method
- Check that the user is authenticated when performing actions

### Missing Fields in Properties
- Only fields specified in `logOnly()` are tracked
- Verify the field names match the model's fillable attributes

### Large Response Payload
- Use pagination (`per_page` parameter)
- Limit date ranges to smaller periods
- Filter by specific model type

---

## Database Tables

The Spatie Activity Log package creates the following tables:

### `activity_log` Table
- `id` - Primary key
- `log_name` - Log type/category
- `description` - Event description
- `subject_type` - Model class name
- `subject_id` - Model record ID
- `causer_type` - User model class name
- `causer_id` - User ID who caused the activity
- `properties` - JSON field with old/new values
- `event` - Event type (created, updated, deleted)
- `batch_uuid` - UUID for batch operations
- `created_at` - Timestamp

---

## Security Considerations

1. **Authorization**: Users can only see their own activity logs
2. **Sensitive Data**: Be careful not to log sensitive information (passwords, tokens)
3. **Access Control**: Activity log endpoints are protected by Sanctum authentication
4. **Rate Limiting**: Consider implementing rate limiting for activity log endpoints
