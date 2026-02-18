import ScrollReveal from '../ui/ScrollReveal';
import styles from './TrustStrip.module.css';

const BRANDS = ['TechCorp', 'FinEdge', 'MediScan', 'NordShop', 'RouteIQ', 'DataPrime'];

export default function TrustStrip() {
    return (
        <section className={styles.trustStrip}>
            <div className="container">
                <ScrollReveal>
                    <p className={styles.label}>Trusted by innovative companies</p>
                    <div className={styles.logos}>
                        {BRANDS.map((brand) => (
                            <span key={brand} className={styles.logoItem}>{brand}</span>
                        ))}
                    </div>
                </ScrollReveal>
            </div>
        </section>
    );
}
