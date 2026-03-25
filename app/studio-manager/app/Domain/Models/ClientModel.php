<?php

declare(strict_types=1);

namespace App\Domain\Models;

class ClientModel extends BaseModel
{
    /**
     * Returns all clients ordered for stable display in admin tables.
     *
     * @return array
     */
    public function findAll(): array
    {
        $sql = 'SELECT numero_client, nom, prenom, email, telephone FROM CLIENT ORDER BY nom ASC, prenom ASC';
        return $this->selectAll($sql);
    }
}
