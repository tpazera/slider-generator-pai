<?php

interface Validator
{
    function checkIfOwner(int $id): bool;
}