<?php

abstract class auth extends session {
    abstract public static function is_valid();
}