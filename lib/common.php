<?php
/**
 * Gets the root path of the project
 *
 * @return string
 */
function getRootPath(): string
{
    return realpath(__DIR__ . '/..');
}
/**
 * Gets the full path for the database file
 *
 * @return string
 */
function getDatabasePath(): string
{
    return getRootPath() . '/data/data.sqlite';
}
/**
 * Gets the DSN for the SQLite connection
 *
 * @return string
 */
function getDsn(): string
{
    return 'sqlite:' . getDatabasePath();
}
/**
 * Gets the PDO object for database access
 *
 * @return \PDO
 */
function getPDO(): PDO
{
    return new PDO(getDsn());
}
