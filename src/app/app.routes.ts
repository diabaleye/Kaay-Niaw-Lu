import { Routes } from '@angular/router';
import { authGuard } from './core/guards/auth.guard';
import { roleGuard } from './core/guards/role.guard';

export const routes: Routes = [
  { path: '', loadComponent: () => import('./features/public/accueil/accueil.component').then(m => m.AccueilComponent) },
  { path: 'a-propos', loadComponent: () => import('./features/public/a-propos/a-propos.component').then(m => m.AProposComponent) },
  { path: 'contact', loadComponent: () => import('./features/public/contact/contact.component').then(m => m.ContactComponent) },
  { path: 'connexion', loadComponent: () => import('./features/auth/connexion/connexion.component').then(m => m.ConnexionComponent) },
  { path: 'inscription', loadComponent: () => import('./features/auth/inscription-identite/inscription-identite.component').then(m => m.InscriptionIdentiteComponent) },
  { path: 'inscription/client', loadComponent: () => import('./features/auth/inscription-client/inscription-client.component').then(m => m.InscriptionClientComponent) },
  { path: 'inscription/tailleur', loadComponent: () => import('./features/auth/inscription-tailleur/inscription-tailleur.component').then(m => m.InscriptionTailleurComponent) },

  // ── CLIENT ────────────────────────────────────────────────────────────────
  {
    path: 'client',
    loadComponent: () => import('./shared/layouts/client-layout/client-layout.component').then(m => m.ClientLayoutComponent),
    canActivate: [authGuard, roleGuard],
    data: { role: 'client' },
    children: [
      { path: 'tableau-de-bord',       loadComponent: () => import('./features/client/tableau-de-bord/tableau-de-bord.component').then(m => m.TableauDeBordClientComponent) },
      { path: 'carnet-de-mesures',      loadComponent: () => import('./features/client/carnet-de-mesures/carnet-de-mesures.component').then(m => m.CarnetDeMesuresComponent) },
      { path: 'historique-commandes',   loadComponent: () => import('./features/client/historique-commandes/historique-commandes.component').then(m => m.HistoriqueCommandesComponent) },
      { path: 'messagerie',             loadComponent: () => import('./features/shared/messagerie/messagerie.component').then(m => m.MessagerieComponent) },
      { path: 'parametres',             loadComponent: () => import('./features/shared/parametres/parametres.component').then(m => m.ParametresComponent) },
      { path: '', redirectTo: 'tableau-de-bord', pathMatch: 'full' },
    ],
  },

  // ── TAILLEUR ──────────────────────────────────────────────────────────────
  {
    path: 'tailleur',
    loadComponent: () => import('./shared/layouts/tailleur-layout/tailleur-layout.component').then(m => m.TailleurLayoutComponent),
    canActivate: [authGuard, roleGuard],
    data: { role: 'tailleur' },
    children: [
      { path: 'tableau-de-bord',  loadComponent: () => import('./features/tailleur/tableau-de-bord/tableau-de-bord.component').then(m => m.TableauDeBordTailleurComponent) },
      { path: 'commandes-recues', loadComponent: () => import('./features/tailleur/commandes-recues/commandes-recues.component').then(m => m.CommandesRecuesComponent) },
      { path: 'atelier-virtuel',  loadComponent: () => import('./features/tailleur/atelier-virtuel/atelier-virtuel.component').then(m => m.AtelierVirtuelComponent) },
      { path: 'messagerie',       loadComponent: () => import('./features/shared/messagerie/messagerie.component').then(m => m.MessagerieComponent) },
      { path: 'parametres',       loadComponent: () => import('./features/shared/parametres/parametres.component').then(m => m.ParametresComponent) },
      { path: '', redirectTo: 'tableau-de-bord', pathMatch: 'full' },
    ],
  },

  // ── ADMIN ─────────────────────────────────────────────────────────────────
  {
    path: 'admin',
    canActivate: [authGuard, roleGuard],
    data: { role: 'admin' },
    children: [{ path: '', redirectTo: 'tableau-de-bord', pathMatch: 'full' }],
  },

  { path: '**', redirectTo: '' },
];
