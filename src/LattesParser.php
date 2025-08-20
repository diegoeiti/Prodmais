<?php

namespace Prodmais\Lattes;

class LattesParser
{
    public function parse(string $xmlFilePath): array
    {
        if (!file_exists($xmlFilePath)) {
            throw new \Exception("Arquivo XML não encontrado: {$xmlFilePath}");
        }

        $xml = simplexml_load_file($xmlFilePath);
        if ($xml === false) {
            throw new \Exception("Erro ao carregar o arquivo XML.");
        }

        $productions = [];
        $researcherName = (string)$xml->{'DADOS-GERAIS'}->attributes()['NOME-COMPLETO'];
        $lattesId = (string)$xml->attributes()['NUMERO-IDENTIFICADOR'];

        // Extrair Artigos Publicados
        if (isset($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'ARTIGOS-PUBLICADOS'})) {
            foreach ($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'ARTIGOS-PUBLICADOS'}->{'ARTIGO-PUBLICADO'} as $item) {
                $dadosBasicos = $item->{'DADOS-BASICOS-DO-ARTIGO'};
                $detalhamento = $item->{'DETALHAMENTO-DO-ARTIGO'};

                $title = (string)$dadosBasicos->attributes()['TITULO-DO-ARTIGO'];
                $year = (string)$dadosBasicos->attributes()['ANO-DO-ARTIGO'];
                $doi = (string)$dadosBasicos->attributes()['DOI'];
                $id = 'lattes_' . $lattesId . '_' . md5($title . $year);

                $productions[] = [
                    'id' => $id,
                    'researcher_name' => $researcherName,
                    'title' => $title,
                    'year' => (int)$year,
                    'type' => 'Artigo Publicado',
                    'doi' => $doi,
                    'source' => 'Lattes'
                ];
            }
        }

        // Adicionar aqui a lógica para outros tipos de produção (Livros, Capítulos, etc.)

        return $productions;
    }
}
