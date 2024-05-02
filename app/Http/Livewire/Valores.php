<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class Valores extends Component
{
    public $uf, $utm, $dolar, $euro;

    public function wire:init()
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.valores');
    }

    private function fetchData()
    {
        try {
            $valores = Http::get('https://mindicador.cl/api/')->json();
            
            // Check if the required values are present in the response
            if (isset($valores['uf']['valor'], $valores['utm']['valor'], $valores['dolar']['valor'], $valores['euro']['valor'])) {
                $this->uf = $valores['uf']['valor'];
                $this->utm = $valores['utm']['valor'];
                $this->dolar = $valores['dolar']['valor'];
                $this->euro = $valores['euro']['valor'];
            } else {
                // Handle missing values
                //$this->emitError('Error: Faltan valores obligatorios en la respuesta de la API.');
                $this->setErrorValues();
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., API request failure)
            //$this->emitError('Error al obtener datos de la API: ' . $e->getMessage());
            $this->setErrorValues();
        }
    }

    private function emitError($message)
    {
        // Emit an error event to handle errors in the Livewire component
        $this->emit('errorOccurred', $message);
    }

    private function setErrorValues()
    {
        // Set error values to 0
        $this->uf = 0;
        $this->utm = 0;
        $this->dolar = 0;
        $this->euro = 0;
    }

    /* --- CODIGO ANTIGUO --- */
    //public $uf, $utm, $dolar, $euro;
    //public function mount(){
        //DATOS DE API
        //$valores = Http::withHeaders([
            //'Accept' => '*/*',
        //])->get('https://mindicador.cl/api/')->json();

        //$this->uf = $valores['uf']['valor'];
        //$this->utm = $valores['utm']['valor'];
        //$this->dolar = $valores['dolar']['valor'];
        //$this->euro = $valores['euro']['valor'];
    //}

    //public function render(){
       // return view('livewire.valores');
    //}
    /* ------ */

}
