import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';

interface CarteArtisan {
  nom: string; atelier: string; adresse: string; telephone: string; note: number;
}

@Component({
  selector: 'app-accueil',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './accueil.component.html',
})
export class AccueilComponent {
  artisans: CarteArtisan[] = [
    { atelier: 'Atelier SAMBA', nom: 'Massamba Ndiaye', adresse: 'Yoff Apecsy II', telephone: '77 777 77 77', note: 5 },
    { atelier: 'Atelier MOUNA', nom: 'Maïmouna Fall',   adresse: 'Yoff Apecsy II', telephone: '77 777 77 77', note: 4 },
    { atelier: 'Atelier Mamy',  nom: 'Mame Codou Diop', adresse: 'Yoff Apecsy II', telephone: '77 777 77 77', note: 5 },
  ];
  etoiles(n: number): number[] { return Array(5).fill(0).map((_,i) => i < n ? 1 : 0); }
}
