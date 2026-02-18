import { Link } from 'react-router-dom';
import styles from './Button.module.css';

/**
 * Button — reusable button/link with variants and sizes.
 *
 * @param {'primary'|'outline'|'ghost'|'white'} variant
 * @param {'sm'|'md'|'lg'} size
 * @param {string} to — if provided, renders a React Router Link
 * @param {string} href — if provided, renders an anchor tag
 */
export default function Button({
    children,
    variant = 'primary',
    size = 'md',
    to,
    href,
    className = '',
    ...props
}) {
    const classes = `${styles.btn} ${styles[variant]} ${styles[size]} ${className}`;

    if (to) {
        return (
            <Link to={to} className={classes} {...props}>
                {children}
            </Link>
        );
    }

    if (href) {
        return (
            <a href={href} className={classes} target="_blank" rel="noopener noreferrer" {...props}>
                {children}
            </a>
        );
    }

    return (
        <button className={classes} {...props}>
            {children}
        </button>
    );
}
