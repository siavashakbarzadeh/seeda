import { Code2, Lightbulb, BrainCircuit } from 'lucide-react';
import SectionHeader from '../ui/SectionHeader';
import Card from '../ui/Card';
import Button from '../ui/Button';
import ScrollReveal from '../ui/ScrollReveal';
import styles from './ServicesPreview.module.css';

const PREVIEW_SERVICES = [
    {
        icon: Code2,
        title: 'Software Development',
        desc: 'Custom-built web & mobile applications using modern frameworks and clean architecture.',
    },
    {
        icon: Lightbulb,
        title: 'Technology Consulting',
        desc: 'Strategic guidance on architecture, tech stack, and digital transformation.',
    },
    {
        icon: BrainCircuit,
        title: 'Data & AI Solutions',
        desc: 'Intelligent systems that help you make data-driven decisions with confidence.',
    },
];

export default function ServicesPreview() {
    return (
        <section className={styles.servicesPreview}>
            <div className="container">
                <ScrollReveal>
                    <SectionHeader
                        label="What We Do"
                        title="Services Built to Scale Your Business"
                        subtitle="We combine deep technical expertise with strategic thinking to deliver solutions that drive real results."
                    />
                </ScrollReveal>

                <div className={styles.grid}>
                    {PREVIEW_SERVICES.map((service, i) => (
                        <ScrollReveal key={service.title} delay={i + 1}>
                            <Card className={styles.serviceItem}>
                                <div className={styles.iconWrap}>
                                    <service.icon size={28} />
                                </div>
                                <h3 className={styles.serviceTitle}>{service.title}</h3>
                                <p className={styles.serviceDesc}>{service.desc}</p>
                            </Card>
                        </ScrollReveal>
                    ))}
                </div>

                <ScrollReveal>
                    <div className={styles.ctaWrap}>
                        <Button to="/services" variant="outline">
                            Explore All Services
                        </Button>
                    </div>
                </ScrollReveal>
            </div>
        </section>
    );
}
