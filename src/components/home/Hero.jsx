import { Code2, BrainCircuit, Rocket } from 'lucide-react';
import Button from '../ui/Button';
import styles from './Hero.module.css';

export default function Hero() {
    return (
        <section className={styles.hero}>
            <div className={`container ${styles.heroContent}`}>
                {/* Left — Text */}
                <div className={styles.heroText}>
                    <div className={styles.badge}>
                        <span className={styles.badgeDot}></span>
                        Software Consulting That Grows With You
                    </div>
                    <h1 className={styles.heroTitle}>
                        We Plant the Seeds of{' '}
                        <span className={styles.heroHighlight}>Digital Innovation</span>
                    </h1>
                    <p className={styles.heroSubtitle}>
                        Seeda is a boutique software consulting company that helps ambitious
                        businesses design, build, and scale modern technology solutions — from
                        idea to impact.
                    </p>
                    <div className={styles.heroCtas}>
                        <Button to="/contact" size="lg">
                            Start a Project
                        </Button>
                        <Button to="/case-studies" variant="outline" size="lg">
                            View Our Work
                        </Button>
                    </div>
                    <div className={styles.heroStats}>
                        <div className={styles.stat}>
                            <h3>50+</h3>
                            <p>Projects Delivered</p>
                        </div>
                        <div className={styles.stat}>
                            <h3>98%</h3>
                            <p>Client Satisfaction</p>
                        </div>
                        <div className={styles.stat}>
                            <h3>8+</h3>
                            <p>Years Experience</p>
                        </div>
                    </div>
                </div>

                {/* Right — Visual */}
                <div className={styles.heroVisual}>
                    <div className={styles.heroGraphic}></div>
                    <div className={styles.floatCard}>
                        <div className={styles.floatIcon} style={{ background: '#ECFDF5', color: '#16A34A' }}>
                            <Code2 size={22} />
                        </div>
                        <div>
                            <h4>Clean Code</h4>
                            <p>Maintainable & scalable</p>
                        </div>
                    </div>
                    <div className={styles.floatCard}>
                        <div className={styles.floatIcon} style={{ background: '#EFF6FF', color: '#2563EB' }}>
                            <BrainCircuit size={22} />
                        </div>
                        <div>
                            <h4>AI-Powered</h4>
                            <p>Smart data solutions</p>
                        </div>
                    </div>
                    <div className={styles.floatCard}>
                        <div className={styles.floatIcon} style={{ background: '#FEF3C7', color: '#D97706' }}>
                            <Rocket size={22} />
                        </div>
                        <div>
                            <h4>Fast Delivery</h4>
                            <p>Agile methodology</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
