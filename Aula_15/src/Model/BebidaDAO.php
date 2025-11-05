<?php
require_once __DIR__ . '/Bebida.php';

class BebidaDAO {
    private $file;

    public function __construct($filePath = null){
        $this->file = $filePath ?? (__DIR__ . '/../../data/bebidas.json');
        if(!file_exists($this->file)){
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function getAll(){
        $json = file_get_contents($this->file);
        $arr = json_decode($json, true) ?: [];
        $result = [];
        foreach($arr as $item){
            $result[] = Bebida::fromArray($item);
        }
        return $result;
    }

    public function save(Bebida $b){
        $all = $this->getAllAsArray();
        // If same name exists, overwrite
        $found = false;
        foreach($all as &$item){
            if($item['nome'] === $b->getNome()){
                $item = $b->toArray();
                $found = true;
                break;
            }
        }
        if(!$found){
            $all[] = $b->toArray();
        }
        file_put_contents($this->file, json_encode($all, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

    public function deleteByName($nome){
        $all = $this->getAllAsArray();
        $all = array_filter($all, function($it) use ($nome){ return $it['nome'] !== $nome; });
        file_put_contents($this->file, json_encode(array_values($all), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

    private function getAllAsArray(){
        $json = file_get_contents($this->file);
        $arr = json_decode($json, true) ?: [];
        return $arr;
    }
}
