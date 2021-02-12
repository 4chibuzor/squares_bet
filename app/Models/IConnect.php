<?php


namespace Models;


interface IConnect
{
  const DB_HOST = SITE_HOST;
  const DB_USER = SITE_USER;
  const DB_PASSWORD = SITE_DB_PASSWORD;
  const DB_NAME = SITE_DB_NAME;
  public static function dbConnect(): \PDO;
}
