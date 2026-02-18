import styles from './SectionHeader.module.css';

/**
 * SectionHeader — consistent section title block.
 *
 * @param {string} label - Uppercase eyebrow label (e.g. "Our Services")
 * @param {string} title - Main heading
 * @param {string} subtitle - Supporting text below the heading
 * @param {boolean} center - Center-align the header
 */
export default function SectionHeader({ label, title, subtitle, center = true }) {
    return (
        <div className={`${styles.sectionHeader} ${center ? styles.center : ''}`}>
            {label && <span className={styles.label}>{label}</span>}
            <h2 className={styles.title}>{title}</h2>
            <div className={styles.accent}></div>
            {subtitle && <p className={styles.subtitle}>{subtitle}</p>}
        </div>
    );
}
