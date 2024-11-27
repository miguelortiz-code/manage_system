<?php

class GlobalSession {
    public function session() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}