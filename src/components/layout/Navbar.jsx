import { useState, useEffect } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { Sprout } from 'lucide-react';
import Button from '../ui/Button';
import styles from './Navbar.module.css';

const NAV_ITEMS = [
    { label: 'Home', path: '/' },
    { label: 'Services', path: '/services' },
    { label: 'Case Studies', path: '/case-studies' },
    { label: 'About', path: '/about' },
    { label: 'Contact', path: '/contact' },
];

export default function Navbar() {
    const [scrolled, setScrolled] = useState(false);
    const [menuOpen, setMenuOpen] = useState(false);
    const location = useLocation();

    useEffect(() => {
        const handleScroll = () => setScrolled(window.scrollY > 20);
        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Close mobile menu on route change
    useEffect(() => {
        setMenuOpen(false);
    }, [location.pathname]);

    // Prevent body scroll when menu is open
    useEffect(() => {
        document.body.style.overflow = menuOpen ? 'hidden' : '';
        return () => { document.body.style.overflow = ''; };
    }, [menuOpen]);

    return (
        <nav className={`${styles.navbar} ${scrolled ? styles.scrolled : ''}`}>
            <div className={`container ${styles.navInner}`}>
                {/* Logo */}
                <Link to="/" className={styles.logo}>
                    <span className={styles.logoIcon}>
                        <Sprout size={20} />
                    </span>
                    Seeda<span className={styles.logoDot}>.</span>
                </Link>

                {/* Desktop nav */}
                <div className={styles.navLinks}>
                    {NAV_ITEMS.map((item) => (
                        <NavLink
                            key={item.path}
                            to={item.path}
                            className={({ isActive }) =>
                                `${styles.navLink} ${isActive ? styles.active : ''}`
                            }
                            end={item.path === '/'}
                        >
                            {item.label}
                        </NavLink>
                    ))}
                </div>

                {/* Desktop CTA */}
                <div className={styles.navCta}>
                    <Button to="/contact" size="sm">
                        Get in Touch
                    </Button>
                </div>

                {/* Mobile hamburger */}
                <button
                    className={`${styles.menuToggle} ${menuOpen ? styles.open : ''}`}
                    onClick={() => setMenuOpen(!menuOpen)}
                    aria-label="Toggle menu"
                >
                    <span />
                    <span />
                    <span />
                </button>
            </div>

            {/* Mobile drawer */}
            <div className={`${styles.mobileDrawer} ${menuOpen ? styles.open : ''}`}>
                {NAV_ITEMS.map((item) => (
                    <NavLink
                        key={item.path}
                        to={item.path}
                        className={({ isActive }) =>
                            `${styles.mobileLink} ${isActive ? styles.active : ''}`
                        }
                        end={item.path === '/'}
                    >
                        {item.label}
                    </NavLink>
                ))}
                <div className={styles.mobileCta}>
                    <Button to="/contact" size="md">
                        Get in Touch
                    </Button>
                </div>
            </div>

            {/* Overlay */}
            <div
                className={`${styles.overlay} ${menuOpen ? styles.open : ''}`}
                onClick={() => setMenuOpen(false)}
            />
        </nav>
    );
}
