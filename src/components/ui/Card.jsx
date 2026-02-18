import styles from './Card.module.css';

/**
 * Card — generic card container with hover lift effect.
 */
export default function Card({ children, className = '', clickable = false, ...props }) {
    return (
        <div
            className={`${styles.card} ${clickable ? styles.clickable : ''} ${className}`}
            {...props}
        >
            {children}
        </div>
    );
}
