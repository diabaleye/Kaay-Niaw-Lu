import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Header } from '../header/header';

@Component({
  selector: 'app-calendrier-livraisons',
  standalone: true,
  imports: [CommonModule, Header],
  templateUrl: './calendrier-livraisons.html',
  styleUrl: './calendrier-livraisons.css'
})
export class CalendrierLivraisons {
  moisActuel: number;
  anneeActuel: number;

  joursLivraison: number[] = [];

  nomsMois = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
  ];

  jours: (number | null)[] = [];

  constructor() {
    const aujourdHui = new Date();
    this.moisActuel = aujourdHui.getMonth();
    this.anneeActuel = aujourdHui.getFullYear();
    this.genererCalendrier();
  }

  genererCalendrier() {
    this.jours = [];
    const premierJourMois = new Date(this.anneeActuel, this.moisActuel, 1).getDay();
    const decalage = premierJourMois === 0 ? 6 : premierJourMois - 1;
    const nbJoursMois = new Date(this.anneeActuel, this.moisActuel + 1, 0).getDate();

    for (let i = 0; i < decalage; i++) {
      this.jours.push(null);
    }
    for (let jour = 1; jour <= nbJoursMois; jour++) {
      this.jours.push(jour);
    }
  }

  moisPrecedent() {
    this.moisActuel--;
    if (this.moisActuel < 0) {
      this.moisActuel = 11;
      this.anneeActuel--;
    }
    this.genererCalendrier();
  }

  moisSuivant() {
    this.moisActuel++;
    if (this.moisActuel > 11) {
      this.moisActuel = 0;
      this.anneeActuel++;
    }
    this.genererCalendrier();
  }

  estLivraison(jour: number | null): boolean {
    return jour !== null && this.joursLivraison.includes(jour);
  }
}