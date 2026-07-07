import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { PublicHeaderComponent } from '../../components/public-header/public-header.component';
import { ApiService } from '../../services/api.service';

interface Artisan {
  id: number;
  name: string;
  workshop_name: string;
  location: string;
  telephone: string;
}

@Component({
  selector: 'app-accueil',
  imports: [PublicHeaderComponent, RouterLink],
  templateUrl: './accueil.component.html',
  styleUrl: './accueil.component.css'
})
export class AccueilComponent implements OnInit {
  artisans: Artisan[] = [
    { id: 1, name: 'Samba DIOP', workshop_name: 'Atelier SAMBA', location: 'Yoff Apecsy II', telephone: '77 777 77 77' },
    { id: 2, name: 'Mouna FALL', workshop_name: 'Atelier MOUNA', location: 'Yoff Apecsy II', telephone: '77 777 77 77' },
    { id: 3, name: 'Mamy NDIAYE', workshop_name: 'Atelier Mamy', location: 'Yoff Apecsy II', telephone: '77 777 77 77' }
  ];

  constructor(private api: ApiService) {}

  ngOnInit(): void {
    this.api.getArtisans().subscribe({
      next: (data) => { if (data?.length) this.artisans = data; },
      error: () => {}
    });
  }
}
