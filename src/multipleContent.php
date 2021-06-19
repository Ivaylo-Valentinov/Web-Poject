<?php
  require_once "book.php";
  require_once "referat.php";
  require_once "requestUtility.php";

  $errors = [];
  $response = [];
  $referat = new Referat();
  $book = new Book();

  $NUM_OF_COLUMNS = 6;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['files'])) {

    $csv_file = null;
    $files;
    $count = count($_FILES['files']['name']);
    for ($i = 0; $i < $count; $i++) {
        if ($_FILES['files']['type'][$i] === 'application/pdf') {
            $files[$_FILES['files']['name'][$i]] = [
                "type" => $_FILES['files']['type'][$i], 
                "tmp_name" => $_FILES['files']['tmp_name'][$i]
            ];
        }

        if ($_FILES['files']['type'][$i] === 'application/vnd.ms-excel' || $_FILES['files']['type'][$i] === 'text/csv') {
            $csv_file = $_FILES['files']['tmp_name'][$i];
        }
    }

    // Check if csv_file exists...

    if (($handle = fopen($csv_file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            $title = $data[0];
            $author = $data[1];
            $desc = $data[2];
            $count = $data[3];
            $type = $data[4];
            $file_name = $data[5];

            // Check if file exists... 
            $file_tmp_name = $files[$file_name]["tmp_name"];
            $file_type = $files[$file_name]["type"];

            $file_name = uniqid().$file_name;
            $link = "pdfs/".$file_name;

            $result;
            if ($type === "Book") {
                $uploadResult = $book->saveBookPDF($file_tmp_name, $file_name, $file_type);
                if (!$uploadResult["success"]) {
                    continue;
                }

                $result = $book->insertBook($title, $author, $desc, $count, $link);
            } else {
                $uploadResult = $referat->saveReferatPDF($file_tmp_name, $file_name, $file_type);
                if (!$uploadResult["success"]) {
                    continue;
                }

                $result = $referat->insertReferat($title, $author, $desc, $count, $link);
            }

            if(!$result["success"]) {
                unlink("../pdfs/".$file_name);
            }
        }
        fclose($handle);
    }


    //  print_r($files);
    //  echo $csv_file;
} else  {
    $errors[] = "Not valid method";
}

  RequestUtility::sendResponse($response, $errors);
?>
