<?php

namespace MomMock\Entity;

class Order extends AbstractEntity
{
    /**
     * Holds the table name
     */
    const TABLE_NAME = 'order';

    /**
     * @var string
     */
    private $incrementId;

    /**
     * @var string
     */
    private $store;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $statusReason;

    /**
     * @var string
     */
    private $originDate;

    /**
     * @var string
     */
    private $json;

    /**
     * @param [] $data
     */
    public function setData(array $data)
    {
        $this->incrementId = $data['id'];
        $this->store = $data['store'];
        $this->status = $data['status'];
        $this->statusReason = $data['status_reason'];
        $this->originDate = $data['origin_date'];
        $this->json = json_encode($data);

        return $this;
    }

    /**
     * Saves an order
     *
     * @return string
     */
    public function save()
    {
        $this->db->createQueryBuilder()
            ->insert(sprintf("`%s`", self::TABLE_NAME))
            ->values([
                '`increment_id`' => "'{$this->incrementId}'",
                '`store`' => "'{$this->store}'",
                '`status`' => "'{$this->status}'",
                '`status_reason`' => "'{$this->statusReason}'",
                '`origin_date`' => "'{$this->originDate}'",
                '`json`' => "'{$this->json}'"
            ])
            ->execute();

        return $this->db->lastInsertId();
    }
}