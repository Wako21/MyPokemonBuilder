import {autoinject, LogManager} from 'aurelia-framework';
import {Logger} from 'aurelia-logging';
import {PLATFORM} from 'aurelia-pal';
import {Router, RouterConfiguration, Redirect} from 'aurelia-router'


@autoinject()
export class App {
    public router: Router;
    private logger:Logger = LogManager.getLogger('App');

    configureRouter(config: RouterConfiguration, router: Router) {
        config.title = 'Vertone';
        config.options.pushState = true;
        config.map([
            {
                route: '/',
                name: 'home',
                moduleId: PLATFORM.moduleName('pages/Home'),
                nav: true,
                title: 'Home',
                settings: {roles: []}
            },
            {
                route: '/home',
                name: 'home',
                moduleId: PLATFORM.moduleName('pages/Home'),
                nav: true,
                title: 'Home',
                settings: {roles: []}
            }
        ]);
        config.fallbackRoute('/');
        config.mapUnknownRoutes({
            redirect: '',
            route: '404'
        });

        this.router = router;
    }

    public constructor()
    {
        this.logger.debug('Constructor');
    }
}



