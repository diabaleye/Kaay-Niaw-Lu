import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

const API = 'http://localhost:8000/api';

@Injectable({ providedIn: 'root' })
export class DashboardService {
  private http = inject(HttpClient);

  getClientDashboard(): Observable<any>  { return this.http.get(`${API}/client/tableau-de-bord`); }
  getTailleurDashboard(): Observable<any> { return this.http.get(`${API}/tailleur/tableau-de-bord`); }
  getProfilMesures(): Observable<any>    { return this.http.get(`${API}/client/profil-mesures`); }
  updateProfilMesures(data: any): Observable<any> { return this.http.put(`${API}/client/profil-mesures`, data); }
  getCommandesClient(): Observable<any>  { return this.http.get(`${API}/client/commandes`); }

  getCommandesTailleur(statut?: string): Observable<any> {
    const params = statut ? `?statut=${statut}` : '';
    return this.http.get(`${API}/tailleur/commandes${params}`);
  }

  changerStatutCommande(id: number, statut: string, progression?: number): Observable<any> {
    return this.http.patch(`${API}/tailleur/commandes/${id}/statut`, { statut, progression });
  }

  getModeles(categorie?: string): Observable<any> {
    const params = categorie && categorie !== 'tous' ? `?categorie=${categorie}` : '';
    return this.http.get(`${API}/tailleur/modeles${params}`);
  }

  /**
   * Crée un modèle avec photo optionnelle.
   * Utilise FormData pour supporter l'upload de fichier.
   */
  creerModele(data: any, photo?: File | null): Observable<any> {
    const fd = new FormData();
    fd.append('titre',     data.titre     ?? '');
    fd.append('tissu',     data.tissu     ?? '');
    fd.append('categorie', data.categorie ?? 'autre');
    fd.append('prix_base', data.prix_base?.toString() ?? '0');
    if (photo) fd.append('photo', photo, photo.name);
    return this.http.post(`${API}/tailleur/modeles`, fd);
  }

  /**
   * Met à jour un modèle — utilise POST + _method=PUT car multipart ne supporte pas PUT natif.
   */
  modifierModele(id: number, data: any, photo?: File | null): Observable<any> {
    const fd = new FormData();
    fd.append('_method',   'PUT');
    fd.append('titre',     data.titre     ?? '');
    fd.append('tissu',     data.tissu     ?? '');
    fd.append('categorie', data.categorie ?? 'autre');
    fd.append('prix_base', data.prix_base?.toString() ?? '0');
    if (photo) fd.append('photo', photo, photo.name);
    // POST avec _method=PUT → Laravel interprétera comme PUT
    return this.http.post(`${API}/tailleur/modeles/${id}`, fd);
  }

  toggleVisibiliteModele(id: number): Observable<any> {
    return this.http.patch(`${API}/tailleur/modeles/${id}/visibilite`, {});
  }

  supprimerModele(id: number): Observable<any> {
    return this.http.delete(`${API}/tailleur/modeles/${id}`);
  }
}
