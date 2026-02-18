import Button from '../ui/Button';
import ScrollReveal from '../ui/ScrollReveal';
import styles from './CtaSection.module.css';

export default function CtaSection() {
    return (
        <section className={styles.ctaSection}>
            <div className="container">
                <ScrollReveal>
                    <div className={styles.inner}>
                        <h2>Ready to Grow Your Business?</h2>
                        <p>
                            Let's talk about your next project. We'll help you find the right
                            technology solution to meet your goals.
                        </p>
                        <Button to="/contact" variant="white" size="lg">
                            Start a Conversation
                        </Button>
                    </div>
                </ScrollReveal>
            </div>
        </section>
    );
}
