-- auto-generated definition
create table if not exists meven_rest
(
  id               int auto_increment primary key,
  name             varchar(100) null,
  address          MEDIUMTEXT   null,
  updated_at       DATETIME     null,
  created_at       DATETIME     null
);
