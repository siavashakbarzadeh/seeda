import { Outlet, useLocation } from 'react-router-dom';
import { useEffect } from 'react';
import Navbar from './Navbar';
import Footer from './Footer';

/**
 * Layout — wraps all routes with Navbar + Footer and scrolls to top on navigation.
 */
export default function Layout() {
    const { pathname } = useLocation();

    // Scroll to top on route change
    useEffect(() => {
        window.scrollTo(0, 0);
    }, [pathname]);

    return (
        <>
            <Navbar />
            <main style={{ paddingTop: '72px' }}>
                <Outlet />
            </main>
            <Footer />
        </>
    );
}
