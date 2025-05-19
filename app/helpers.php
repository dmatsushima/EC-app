<?php

function isAdmin(): bool
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['is_admin']);
}
