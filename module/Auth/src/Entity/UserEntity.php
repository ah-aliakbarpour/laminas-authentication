<?php

namespace Auth\Entity;

/**
 * @Entity(repositoryClass="Auth\Repository\UserRepository")
 */
class UserEntity
{
    /**
     * @Column(type="int")
     */
    public $id;

    /**
     * @Column(type="string", nullable=false)
     */
    public $name;

    /**
     * @Column(type="string", unique=true, nullable=false)
     */
    public $email;

    /**
     * @Column(type="string", nullable=false)
     */
    public $password;

    /**
     * @Column(type="datetime")
     */
    public $created_at;

    /**
     * @Column(type="datetime")
     */
    public $updated_at;
}