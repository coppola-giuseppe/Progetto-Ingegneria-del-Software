<?php


class EsameLaureando
{
    public string $nomeEsame;
    public string $codiceEsame;
    public string $cfuEsame;
    public int $votoEsame;
    public bool $curricolare;
    public bool $faMedia;
    public bool $informatico;

    public function __construct(
        string $nomeEsame,
        string $codiceEsame,
        string $cfuEsame,
        int $votoEsame,
        bool $curricolare,
        bool $faMedia,
        bool $informatico
    ) {
        $this->nomeEsame = $nomeEsame;
        $this->codiceEsame = $codiceEsame;
        $this->cfuEsame = $cfuEsame;
        $this->votoEsame = $votoEsame;
        $this->curricolare = $curricolare;
        $this->faMedia = $faMedia;
        $this->informatico = $informatico;
    }
}

?>