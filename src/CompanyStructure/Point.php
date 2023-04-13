<?php

namespace App\CompanyStructure;

class Point
{
    private string $name;
    /**
     * @var Point[]
     */
    private array $children = [];

    private ?Point $parent;

    /**
     * @var User[]
     */
    private array $userAccess = [];

    public function __construct(string $name, ?Point $parent)
    {
        $this->name = $name;
        $this->parent = $parent;
        if ($this->parent !== null) {
            $this->parent->children[] = $this;
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function addAccessToUser(User $user): void
    {
        $this->userAccess[] = $user;
    }

    /**
     * @param User $user
     * @return bool
     * Если в узле нет доступа для пользователя, то проверка доступа осуществляется родительским узлом
     */
    public function checkUserAccess(User $user): bool
    {
        $isAccess = in_array($user, $this->userAccess, true);
        if ($isAccess) {
            return true;
        }

        if ($this->parent !== null) {
            return $this->parent->checkUserAccess($user);
        }

        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStructureAsText(int $level = 0): string
    {
        $result = str_repeat('_', $level) . $this->name . "\n";
        foreach ($this->children as $child) {
            $result .= $child->getStructureAsText($level + 1);
        }
        return $result;
    }

}