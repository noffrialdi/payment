CREATE TABLE `transaction` (
   `id` uuid NOT NULL PRIMARY KEY,
   `invoice_id` VARCHAR(255) NOT NULL,  
   `references_id` VARCHAR(255) NOT NULL,  
   `item_name` VARCHAR(255) NULL,  
   `amount` bigint NULL,  
   `payment_type` VARCHAR(255) NULL,
   `customer_name` VARCHAR(255) NULL,
   `number_va` VARCHAR(255) NULL,
   `payment_status` int DEFAULT 0,
   `merchant_id` VARCHAR(255) NOT NULL,
   `created_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
);