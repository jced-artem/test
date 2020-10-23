<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ShortUrl
 *
 * @ORM\Table(name="short_url", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="code", columns={"code"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class ShortUrl
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
	 * @Assert\Url
	 * @Assert\NotBlank
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=16, nullable=false)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="hits", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $hits = '0';

    /**
     * @var int|null
	 * @Assert\NotBlank
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=false)
     */
    private $expiresAt;

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getLink(): string
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 * @return ShortUrl
	 */
	public function setLink(string $link): ShortUrl
	{
		$this->link = $link;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCode(): string
	{
		return $this->code;
	}

	/**
	 * @param string $code
	 * @return ShortUrl
	 */
	public function setCode(string $code): ShortUrl
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getHits(): int
	{
		return $this->hits;
	}

	/**
	 * @param int $hits
	 * @return ShortUrl
	 */
	public function setHits(int $hits): ShortUrl
	{
		$this->hits = $hits;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getUserId(): ?int
	{
		return $this->userId;
	}

	/**
	 * @param int|null $userId
	 * @return ShortUrl
	 */
	public function setUserId(?int $userId): ShortUrl
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getExpiresAt(): ?\DateTime
	{
		return $this->expiresAt;
	}

	/**
	 * @param \DateTime $expiresAt
	 * @return ShortUrl
	 */
	public function setExpiresAt(\DateTime $expiresAt): ShortUrl
	{
		$this->expiresAt = $expiresAt;
		return $this;
	}
}
