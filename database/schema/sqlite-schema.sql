CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "grade" integer not null,
  "admin" tinyint(1) not null default '0',
  "birthday" datetime,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "deleted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "band_members"(
  "id" integer primary key autoincrement not null,
  "band_id" integer not null,
  "member_id" integer,
  "name" varchar not null,
  "part" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("band_id") references "bands"("id") on delete cascade,
  foreign key("member_id") references "users"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "studios"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "made_user_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  "deleted_at" datetime,
  foreign key("made_user_id") references "users"("id")
);
CREATE TABLE IF NOT EXISTS "studio_reservations"(
  "id" integer primary key autoincrement not null,
  "use_datetime" datetime not null,
  "studio_id" integer not null,
  "reserved_user_id" integer not null,
  "reserved_band_id" varchar not null,
  "deleted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("reserved_user_id") references users("id") on delete no action on update no action,
  foreign key("studio_id") references studios("id") on delete no action on update no action
);
CREATE INDEX "studio_reservations_studio_id_use_datetime_index" on "studio_reservations"(
  "studio_id",
  "use_datetime"
);
CREATE TABLE IF NOT EXISTS "lives"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "held_date" datetime not null,
  "entry_due" datetime not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "bands"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "made_by" integer not null,
  "vote" integer not null default('0'),
  "live_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("made_by") references users("id") on delete no action on update no action,
  foreign key("live_id") references "lives"("id") on delete cascade
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2024_03_21_000000_create_bands_table',1);
INSERT INTO migrations VALUES(5,'2024_04_07_065756_create_band_members_table',1);
INSERT INTO migrations VALUES(6,'2024_10_05_184559_create_studios_table',1);
INSERT INTO migrations VALUES(7,'2024_10_06_120219_create_studio_reservations_table',1);
INSERT INTO migrations VALUES(8,'2025_03_15_174044_change_band_column_reservation_tmp',1);
INSERT INTO migrations VALUES(9,'2025_04_07_134009_create_lives_table',1);
INSERT INTO migrations VALUES(10,'2025_04_08_161501_update_bands_live_id_foreign_key',1);
INSERT INTO migrations VALUES(11,'2025_04_08_163311_update_bands_live_id_required',1);
