<?php

class ModelAktikom
{
    public $line;
    public $lines;
    private $line_ar;

    public $code = 0; // Код
    public $name = 1; // Наименование
    public $level_1 = 2; // Уровень1
    public $level_2 = 3; // Уровень2
    public $level_3 = 4; // Уровень3
    public $cost = 5; // Цена
    public $costSP = 6; // ЦенаСП
    public $count = 7; // Количество
    public $fields_options = 8; // Поля свойств
    public $us_pay = 9; // Совместные покупки
    public $unit = 10; // Единица измерения
    public $picture = 11; // Картинка
    public $view_on_main = 12; // Выводить на главной
    public $desc = 13; // Описание

    public function line_exp ($delimenator = ";")
    {
        $this->line_ar = explode($delimenator,$this->line);
        $this->trim_massiv($this->line_ar);
    }

    public function line_add_db ()
    {
        DB::query("INSERT INTO `goods`(`code`, `name`, `level_1`, `level_2`, `level_3`, `cost`, `costSP`, `count`, 
                    `fields_options`, `us_pay`, `unit`, `picture`, `view_on_main`, `description`) VALUES (".
            "code = ".$this->line_ar[$this->code].
            "name = ".$this->line_ar[$this->name].
            "level_1 = ".$this->line_ar[$this->level_1].
            "level_2 = ".$this->line_ar[$this->level_2].
            "level_3 = ".$this->line_ar[$this->level_3].
            "cost = ".$this->line_ar[$this->cost].
            "costSP = ".$this->line_ar[$this->costSP].
            "count = ".$this->line_ar[$this->count].
            "fields_options = ".$this->line_ar[$this->fields_options].
            "us_pay = ".$this->line_ar[$this->us_pay].
            "unit = ".$this->line_ar[$this->unit].
            "picture = ".$this->line_ar[$this->picture].
            "view_on_main = ".$this->line_ar[$this->view_on_main].
            "description = ".$this->line_ar[$this->desc]
            .");") or die (DB::error());
        $good_id = DB::insert_id();
        return ['good_id' => $good_id];
    }

    public function get_line_ar ()
    {
        return $this->line_ar;
    }

    public function line_view_associative ()
    {
        $line_ar_associative = [
            "code" => $this->line_ar[$this->code],
            "name" => $this->line_ar[$this->name],
            "level_1" => $this->line_ar[$this->level_1],
            "level_2" => $this->line_ar[$this->level_2],
            "level_3" => $this->line_ar[$this->level_3],
            "cost" => $this->line_ar[$this->cost],
            "costSP" => $this->line_ar[$this->costSP],
            "count" => $this->line_ar[$this->count],
            "fields_options" => $this->line_ar[$this->fields_options],
            "us_pay" => $this->line_ar[$this->us_pay],
            "unit" => $this->line_ar[$this->unit],
            "picture" => $this->line_ar[$this->picture],
            "view_on_main" => $this->line_ar[$this->view_on_main],
            "desc" => $this->line_ar[$this->desc]
        ];
        return $line_ar_associative;
    }

    private function trim_massiv (&$array,$el = "\" ")
    {
        foreach ($array as $key => $item)
        {
            $array[$key] = trim($array[$key],$el);
            $array[$key] = preg_replace('/["]/', '', $array[$key]);
        }
    }

    public function view ($simple_view = true, $count = 0)
    {
        $count_lines_ar = count($this->lines);
        if ($count == 0) {
            $lenght = $count_lines_ar;
        }
        else {
            if (count($this->lines) > $count) $lenght = $count + 1;
            else $lenght = $count_lines_ar;
        }
        for ($i = 1; $i < $lenght;$i++) {
            $this->line = $this->lines[$i];
            $this->line_exp();
            if ($simple_view) {
                $line_assoc = $this->line_view_associative();
                echo $line_assoc['code']."====".$line_assoc['name']."====".$line_assoc['desc'];
            } else {
                $line_array = $this->get_line_ar();
                for ($j = 0; $j < count($line_array); $j++)
                {
                    echo $line_array[$j]." | ";
                }
            }
            echo "<br />\n";
        }
    }

    public function read_file_in_array($name_file = '')
    {
        $this->lines = file($name_file);
    }
}