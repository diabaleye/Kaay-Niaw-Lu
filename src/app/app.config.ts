import { ApplicationConfig, provideAppInitializer, inject } from '@angular/core';
import { provideRouter } from '@angular/router';
import { provideHttpClient, withInterceptors } from '@angular/common/http';
import { routes } from './app.routes';
import { authInterceptor } from './core/interceptors/auth.interceptor';
import { AuthService } from './core/services/auth.service';

export const appConfig: ApplicationConfig = {
  providers: [
    provideRouter(routes),

    // HttpClient avec l'intercepteur Bearer token
    provideHttpClient(withInterceptors([authInterceptor])),

    // Vérifier le token au démarrage de l'app
    provideAppInitializer(() => {
      const auth = inject(AuthService);
      return auth.initialiser();
    }),
  ],
};
