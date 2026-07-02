import { Injectable, signal, computed, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { tap } from 'rxjs/operators';
import { Observable } from 'rxjs';
import {
  User, AuthResponse, ConnexionPayload,
  InscriptionClientPayload, InscriptionTailleurPayload
} from '../models/user.model';

const TOKEN_KEY = 'knl_token';
const API = 'http://localhost:8000/api';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private http   = inject(HttpClient);
  private router = inject(Router);

  // ── State réactif avec Signals ────────────────────────────────
  private _user  = signal<User | null>(null);
  private _token = signal<string | null>(localStorage.getItem(TOKEN_KEY));

  // Selectors publics (lecture seule)
  readonly user        = this._user.asReadonly();
  readonly token       = this._token.asReadonly();
  readonly estConnecte = computed(() => this._token() !== null);
  readonly estClient   = computed(() => this._user()?.role === 'client');
  readonly estTailleur = computed(() => this._user()?.role === 'tailleur');
  readonly estAdmin    = computed(() => this._user()?.role === 'admin');

  // ── Auth endpoints ────────────────────────────────────────────

  inscrireClient(payload: InscriptionClientPayload): Observable<AuthResponse> {
    return this.http
      .post<AuthResponse>(`${API}/auth/inscription/client`, payload)
      .pipe(tap(res => this.sauvegarderSession(res)));
  }

  inscrireTailleur(payload: InscriptionTailleurPayload): Observable<AuthResponse> {
    return this.http
      .post<AuthResponse>(`${API}/auth/inscription/tailleur`, payload)
      .pipe(tap(res => this.sauvegarderSession(res)));
  }

  connecter(payload: ConnexionPayload): Observable<AuthResponse> {
    return this.http
      .post<AuthResponse>(`${API}/auth/connexion`, payload)
      .pipe(tap(res => this.sauvegarderSession(res)));
  }

  chargerUtilisateurConnecte(): Observable<{ user: User }> {
    return this.http
      .get<{ user: User }>(`${API}/auth/moi`)
      .pipe(tap(res => this._user.set(res.user)));
  }

  deconnecter(): void {
    // Appel API en best-effort (on déconnecte côté client même si ça échoue)
    this.http.post(`${API}/auth/deconnexion`, {}).subscribe({
      error: () => {} // ignorer l'erreur réseau
    });
    this.effacerSession();
    this.router.navigate(['/connexion']);
  }

  // ── Helpers internes ─────────────────────────────────────────

  private sauvegarderSession(res: AuthResponse): void {
    localStorage.setItem(TOKEN_KEY, res.token);
    this._token.set(res.token);
    this._user.set(res.user);
  }

  effacerSession(): void {
    localStorage.removeItem(TOKEN_KEY);
    this._token.set(null);
    this._user.set(null);
  }

  /**
   * Appelé au démarrage de l'app (APP_INITIALIZER).
   * Si un token existe en localStorage, on vérifie qu'il est encore valide.
   */
  initialiser(): Promise<void> {
    if (!this._token()) return Promise.resolve();

    return new Promise(resolve => {
      this.chargerUtilisateurConnecte().subscribe({
        next: () => resolve(),
        error: () => {
          this.effacerSession();
          resolve();
        }
      });
    });
  }

  /**
   * Redirige vers le bon tableau de bord selon le rôle.
   */
  redirigerSelonRole(): void {
    const role = this._user()?.role;
    if (role === 'tailleur') this.router.navigate(['/tailleur/tableau-de-bord']);
    else if (role === 'admin') this.router.navigate(['/admin/tableau-de-bord']);
    else this.router.navigate(['/client/tableau-de-bord']);
  }
}
