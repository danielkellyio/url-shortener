import UrlsPage from './pages/urls'
import AnalyticsPage from './pages/analytics'
export default [
    {
        path:'/',
        redirect: '/urls'
    },
    {
        path: '/urls',
        component: UrlsPage,
    },
    {
        path: '/analytics',
        component: AnalyticsPage,
    }
]
