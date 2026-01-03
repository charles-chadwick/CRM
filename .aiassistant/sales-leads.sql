CREATE TABLE `sale_leads_progress`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sales_lead_id` int(11) NULL DEFAULT 0,
  `status` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text NULL,
  `contacted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL,
  `created_by_id` int(11) NOT NULL DEFAULT 1,
  `updated_by_id` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sales_leads`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NULL DEFAULT 0,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text NULL,
  `contacted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL,
  `created_by_id` int(11) NOT NULL DEFAULT 1,
  `updated_by_id` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

ALTER TABLE `sale_leads_progress` ADD CONSTRAINT `fk_sales_lead_id` FOREIGN KEY (`sales_lead_id`) REFERENCES `sales_leads` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

