<?php
namespace App\CentralLogics;
use Illuminate\Support\Facades\App;

class Helpers
{
    public static function translate($key, $replace = [])
    {
        $key = strpos($key, 'messages.') === 0?substr($key,9):$key;
        $local = self::default_lang();
        App::setLocale($local);
        try {
            $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));

            if (!array_key_exists($key, $lang_array)) {
                $processed_key = str_replace('_', ' ', self::remove_invalid_charcaters($key));
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
                $result = $processed_key;
            } else {
                $result = trans('messages.' . $key, $replace);
            }
        } catch (\Exception $exception) {
            info($exception);
            $result = trans('messages.' . $key, $replace);
        }

        return $result;
    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => self::translate($error[0])]);
        }
        return $err_keeper;
    }

    public static function error_formater($key, $mesage, $errors = [])
    {
        $errors[] = ['code' => $key, 'message' => $mesage];

        return $errors;
    }
    
    public static function default_lang()
    {
        // Valor predeterminado si no se encuentra el idioma o no coincide con 'en' o 'es'
        return 'es';
    }

    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
    }
}