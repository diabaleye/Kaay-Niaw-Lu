import { Component, inject, signal, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import { DashboardService } from '../../../core/services/dashboard.service';

@Component({
  selector: 'app-atelier-virtuel',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './atelier-virtuel.component.html',
})
export class AtelierVirtuelComponent implements OnInit {
  private svc = inject(DashboardService);
  private fb  = inject(FormBuilder);

  modeles         = signal<any[]>([]);
  chargement      = signal(true);
  filtreActif     = signal('tous');
  afficherModal   = signal(false);
  modeleEnEdition = signal<any>(null);
  sauvegarde      = signal(false);
  erreurModal     = signal<string | null>(null);

  // Fichier photo sélectionné
  photoSelectionnee: File | null = null;
  photoPreview = signal<string | null>(null);

  categories = [
    { label: 'Tous les modeles',  valeur: 'tous' },
    { label: 'Grands boubous',    valeur: 'grands_boubous' },
    { label: 'Kaftans et robes',  valeur: 'kaftans_et_robes' },
    { label: 'Tuniques modernes', valeur: 'tuniques_modernes' },
  ];

  form = this.fb.group({
    titre:     ['', Validators.required],
    tissu:     [''],
    categorie: ['autre'],
    prix_base: [null as number | null, [Validators.required, Validators.min(0)]],
  });

  ngOnInit() { this.charger(); }

  charger(cat?: string) {
    this.filtreActif.set(cat ?? 'tous');
    this.chargement.set(true);
    this.svc.getModeles(cat).subscribe({
      next: (d: any) => { this.modeles.set(d.modeles); this.chargement.set(false); },
      error: () => this.chargement.set(false),
    });
  }

  ouvrir(modele?: any) {
    this.modeleEnEdition.set(modele ?? null);
    this.photoSelectionnee = null;
    this.photoPreview.set(modele?.photo_url ?? null);
    this.erreurModal.set(null);
    modele ? this.form.patchValue(modele) : this.form.reset({ categorie: 'autre' });
    this.afficherModal.set(true);
  }

  fermer() {
    this.afficherModal.set(false);
    this.modeleEnEdition.set(null);
    this.photoSelectionnee = null;
    this.photoPreview.set(null);
  }

  onPhotoChoisie(event: Event) {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];
    if (!file) return;
    // Vérifier la taille (3 MB max)
    if (file.size > 3 * 1024 * 1024) {
      this.erreurModal.set('La photo ne doit pas dépasser 3 MB.');
      return;
    }
    this.photoSelectionnee = file;
    // Prévisualisation locale
    const reader = new FileReader();
    reader.onload = (e) => this.photoPreview.set(e.target?.result as string);
    reader.readAsDataURL(file);
  }

  sauvegarder() {
    if (this.form.invalid) { this.form.markAllAsTouched(); return; }
    this.sauvegarde.set(true);
    this.erreurModal.set(null);

    const data = this.form.value;
    const obs = this.modeleEnEdition()
      ? this.svc.modifierModele(this.modeleEnEdition().id, data, this.photoSelectionnee)
      : this.svc.creerModele(data, this.photoSelectionnee);

    obs.subscribe({
      next: () => { this.fermer(); this.charger(this.filtreActif()); this.sauvegarde.set(false); },
      error: (err: any) => {
        this.sauvegarde.set(false);
        const msg = err.error?.message ?? 'Erreur lors de la sauvegarde.';
        this.erreurModal.set(msg);
      },
    });
  }

  toggleVisibilite(m: any) {
    this.svc.toggleVisibiliteModele(m.id).subscribe({ next: () => this.charger(this.filtreActif()) });
  }

  supprimer(m: any) {
    if (!confirm(`Supprimer "${m.titre}" ?`)) return;
    this.svc.supprimerModele(m.id).subscribe({ next: () => this.charger(this.filtreActif()) });
  }

  formatPrix(p: number): string {
    return new Intl.NumberFormat('fr-FR').format(p);
  }
}
