<?php 
    function generateOrderReference($length = 8) {
        // Characters to use for the order reference
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        // Initialize the order reference
        $orderReference = '';
    
        // Generate a random order reference of the specified length
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $orderReference .= $characters[$randomIndex];
        }
    
        return $orderReference;
    }
    function generateConfirmationCode($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
    
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $code;
    }
?>
