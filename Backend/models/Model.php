<?php
namespace Models;

use PDO;

abstract class Model
{
    /**
     * The connection.
     *
     * @var PDO
     */
    protected PDO $connection;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected string $table;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * The properties for the model.
     *
     * @var string
     */
    protected array $properties = [];

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

}
