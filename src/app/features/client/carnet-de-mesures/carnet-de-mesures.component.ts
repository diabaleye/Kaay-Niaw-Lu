import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder } from '@angular/forms';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-carnet-de-mesures',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './carnet-de-mesures.component.html',
})
export class CarnetDeMesuresComponent implements OnInit {
  private svc = inject(DashboardService);
  private fb  = inject(FormBuilder);

  nom      = signal('');
  majLe    = signal<string | null>(null);
  chargement = signal(true);
  sauvegarde = signal(false);
  succes     = signal(false);

  form = this.fb.group({
    tour_cou:        [null as number | null],
    tour_poitrine:   [null as number | null],
    longueur_bras:   [null as number | null],
    tour_taille:     [null as number | null],
    epaule:          [null as number | null],
    hanches:         [null as number | null],
    longueur_jambes: [null as number | null],
    tour_cuisses:    [null as number | null],
  });

  hautsCorps = [
    { key: 'tour_cou',      label: 'Cou' },
    { key: 'tour_poitrine', label: 'Tour de Poitrine' },
    { key: 'longueur_bras', label: 'Longueur Bras' },
    { key: 'tour_taille',   label: 'Tour de Taille' },
    { key: 'epaule',        label: 'Epaule' },
  ];

  basCorps = [
    { key: 'hanches',         label: 'Hanches' },
    { key: 'longueur_jambes', label: 'Longueur Jambes' },
    { key: 'tour_cuisses',    label: 'Tour de Cuisses' },
  ];

  ngOnInit() {
    this.svc.getProfilMesures().subscribe({
      next: (d: any) => {
        this.nom.set(d.nom);
        this.majLe.set(d.profil.mis_a_jour_le);
        this.form.patchValue(d.profil);
        this.chargement.set(false);
      },
      error: () => this.chargement.set(false),
    });
  }

  enregistrer() {
    this.sauvegarde.set(true);
    this.svc.updateProfilMesures(this.form.value).subscribe({
      next: (d: any) => {
        this.majLe.set(d.profil.mis_a_jour_le);
        this.sauvegarde.set(false);
        this.succes.set(true);
        setTimeout(() => this.succes.set(false), 3000);
      },
      error: () => this.sauvegarde.set(false),
    });
  }
}
