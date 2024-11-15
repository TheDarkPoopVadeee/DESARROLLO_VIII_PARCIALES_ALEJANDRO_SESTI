<?php
class GoogleBooks {
    public function searchBooks($query) {
        $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($query);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
?>
