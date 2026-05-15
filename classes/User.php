<?php
    class User
    {
        private int $id;
        private string $name;
        private string $password;
        private string $role;

        public function __construct(int $id, string $name, string $password, string $role = 'user')
        {
            $this->id = $id;
            $this->name = $name;
            $this->password = $password;
            $this->role = $role;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function getRole(): string
        {
            return $this->role;
        }
    }
?>
