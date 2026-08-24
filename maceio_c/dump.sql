CREATE DATABASE gonzaga_barber_api;
use gonzaga_barber_api;
create table customers
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table plans
(
    id                  bigint unsigned auto_increment
        primary key,
    name                varchar(255) not null,
    price               int          not null,
    monthly_usage_limit int          not null,
    created_at          timestamp    null,
    updated_at          timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table subscriptions
(
    id          bigint unsigned auto_increment
        primary key,
    plan_id     bigint unsigned not null,
    start_date  datetime        not null,
    customer_id bigint unsigned not null,
    created_at  timestamp       null,
    updated_at  timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table transactions
(
    id               bigint unsigned auto_increment
        primary key,
    subscription_id  bigint unsigned                                                                   not null,
    amount           int                                                                               not null,
    transaction_date datetime                                                                          not null,
    status           enum ('Paid', 'Pending', 'Not apply', 'Suspended', 'Cancelled') default 'Pending' not null,
    usage_count      int                                                                               not null,
    worker_id        bigint unsigned                                                                   null,
    description      text                                                                              null,
    created_at       timestamp                                                                         null,
    updated_at       timestamp                                                                         null
)
    collate = utf8mb4_unicode_ci;

create table users
(
    id         bigint unsigned auto_increment
        primary key,
    username   varchar(255) not null,
    password   varchar(255) not null,
    token      varchar(255) null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table workers
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

