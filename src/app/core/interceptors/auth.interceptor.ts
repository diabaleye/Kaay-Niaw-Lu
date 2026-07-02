import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { AuthService } from '../services/auth.service';

/**
 * Intercepteur fonctionnel (Angular 17+).
 * Ajoute automatiquement "Authorization: Bearer <token>" sur toutes
 * les requêtes vers l'API Laravel.
 */
export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const auth  = inject(AuthService);
  const token = auth.token();

  if (token) {
    const reqAvecToken = req.clone({
      setHeaders: { Authorization: `Bearer ${token}` }
    });
    return next(reqAvecToken);
  }

  return next(req);
};
