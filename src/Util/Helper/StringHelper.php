<?php

namespace App\Util\Helper;

class StringHelper
{
    public static function createSlug(string $string, string $separator = '-', bool $lowercase = true): string
    {
        if (!$string) {
            return '';
        }

        $arrUnicodeChars = [
            "ạ", "á", "à", "ả", "ã", "Ạ", "Á", "À", "Ả", "Ã",
            "â", "ậ", "ấ", "ầ", "ẩ", "ẫ", "Â", "Ậ", "Ấ", "Ầ", "Ẩ", "Ẫ",
            "ă", "ặ", "ắ", "ằ", "ẳ", "ẫ", "ẵ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ",
            "ê", "ẹ", "é", "è", "ẻ", "ẽ", "Ê", "Ẹ", "É", "È", "Ẻ", "Ẽ",
            "ế", "ề", "ể", "ễ", "ệ", "Ế", "Ề", "Ể", "Ễ", "Ệ",
            "ọ", "ộ", "ổ", "ỗ", "ố", "ồ", "Ọ", "Ộ", "Ổ", "Ỗ", "Ố", "Ồ", "Ô", "ô",
            "ó", "ò", "ỏ", "õ", "Ó", "Ò", "Ỏ", "Õ",
            "ơ", "ợ", "ớ", "ờ", "ở", "ỡ",
            "Ơ", "Ợ", "Ớ", "Ờ", "Ở", "Ỡ",
            "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự", "Ụ", "Ư", "Ứ", "Ừ", "Ử", "Ữ", "Ự",
            "ú", "ù", "ủ", "ũ", "Ú", "Ù", "Ủ", "Ũ",
            "ị", "í", "ì", "ỉ", "ĩ", "Ị", "Í", "Ì", "Ỉ", "Ĩ",
            "ỵ", "ý", "ỳ", "ỷ", "ỹ", "Ỵ", "Ý", "Ỳ", "Ỷ", "Ỹ",
            "đ", "Đ"
        ];
        $arrNonUnicodeChars = [
            "a", "a", "a", "a", "a", "A", "A", "A", "A", "A",
            "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
            "a", "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
            "e", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "E",
            "e", "e", "e", "e", "e", "E", "E", "E", "E", "E",
            "o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O", "O", "o",
            "o", "o", "o", "o", "O", "O", "O", "O",
            "o", "o", "o", "o", "o", "o",
            "O", "O", "O", "O", "O", "O",
            "u", "u", "u", "u", "u", "u", "u", "U", "U", "U", "U", "U", "U", "U",
            "u", "u", "u", "u", "U", "U", "U", "U",
            "i", "i", "i", "i", "i", "I", "I", "I", "I", "I",
            "y", "y", "y", "y", "y", "Y", "Y", "Y", "Y", "Y",
            "d", "D"
        ];
        $arrSpecialChars = [
            '!', '"', '#', '$', '%', '&',
            "'", '(', ')', '*', '+', ',',
            '-', '.', '/', ':', ';', '<',
            '=', '>', '?', '@', '[', '\\',
            ']', '^', '_', '`', '{', '|',
            '}', '~'
        ];

        // Convert unicode to non-unicode
        $string = str_replace($arrUnicodeChars, $arrNonUnicodeChars, $string);
        // Remove Non ASCII Characters
        $string = preg_replace("/[^(\x20-\x7F)]*/", '', $string);
        // Convert Special characters to space
        $string = str_replace($arrSpecialChars, ' ', $string);

        // Convert many spaces to space
        $string = preg_replace("/\s+/", ' ', $string);
        // Remove spaces from head and tail
        $string = trim($string);
        // Use separator to separate words
        $string = str_replace(' ', $separator, $string);

        if ($lowercase) {
            $string = strtolower($string);
        }

        return $string;
    }

    public static function randomString(int $length, string $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        $string = '';

        $charctersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $charctersLength - 1);
            $string .= $characters[$index];
        }

        return $string;
    }
}