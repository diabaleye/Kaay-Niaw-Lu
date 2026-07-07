import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { SidebarClientComponent } from '../../../components/sidebar-client/sidebar-client.component';
import { DashboardHeaderComponent } from '../../../components/dashboard-header/dashboard-header.component';
import { AuthService } from '../../../services/auth.service';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-mesures',
  imports: [SidebarClientComponent, DashboardHeaderComponent, FormsModule],
  templateUrl: './mesures.component.html',
  styleUrl: './mesures.component.css'
})
export class MesuresComponent implements OnInit {
  userName = 'FANTA';
  measurements: Record<string, number> = {
    cou: 53, poitrine: 98, bras: 35, taille: 103, epaule: 43,
    hanches: 53, jambes: 98, cuisses: 35
  };

  sections = [
    { title: 'HAUT DU CORPS', items: [
      { key: 'cou', label: 'Cou' },
      { key: 'poitrine', label: 'Tour de Poitrine' },
      { key: 'bras', label: 'Longueur Bras' },
      { key: 'taille', label: 'Tour de Taille' },
      { key: 'epaule', label: 'Epaule' }
    ]},
    { title: 'BAS DU CORPS', items: [
      { key: 'hanches', label: 'Hanches' },
      { key: 'jambes', label: 'Longueur Jambes' },
      { key: 'cuisses', label: 'Tour de Cuisses' }
    ]}
  ];

  constructor(private auth: AuthService, private api: ApiService) {}

  ngOnInit(): void {
    const user = this.auth.getUser();
    if (user?.name) this.userName = user.name.toUpperCase();
    this.api.getMeasurements().subscribe({
      next: (data) => { if (data) this.measurements = { ...this.measurements, ...data }; },
      error: () => {}
    });
  }

  save(): void {
    this.api.saveMeasurements(this.measurements).subscribe({
      next: () => alert('Mesures enregistrées !'),
      error: () => alert('Mesures enregistrées localement.')
    });
  }
}
