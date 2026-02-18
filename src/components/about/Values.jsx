import { Target, Users, Zap, Shield } from 'lucide-react';
import ScrollReveal from '../ui/ScrollReveal';
import SectionHeader from '../ui/SectionHeader';
import styles from './Values.module.css';

const VALUES = [
    {
        icon: Target,
        title: 'Impact-Driven',
        desc: 'Every line of code we write serves a purpose. We focus on solutions that create real value.',
    },
    {
        icon: Users,
        title: 'Client Partnership',
        desc: 'We treat every project like it's our own.Transparent communication at every step.',
  },
    {
        icon: Zap,
        title: 'Technical Excellence',
        desc: 'We stay ahead of the curve. Modern stacks, clean architecture, battle-tested practices.',
    },
    {
        icon: Shield,
        title: 'Reliability',
        desc: 'We deliver on time, within budget, and stand behind our work long after launch.',
    },
];

export default function Values() {
    return (
        <section className={styles.values}>
            <div className="container">
                <ScrollReveal>
                    <SectionHeader
                        label="Our Values"
                        title="What Drives Us"
                        subtitle="The principles that guide every project and partnership."
                    />
                </ScrollReveal>
                <div className={styles.grid}>
                    {VALUES.map((value, i) => (
                        <ScrollReveal key={value.title} delay={i + 1}>
                            <div className={styles.valueItem}>
                                <div className={styles.iconWrap}>
                                    <value.icon size={24} />
                                </div>
                                <h3 className={styles.valueTitle}>{value.title}</h3>
                                <p className={styles.valueDesc}>{value.desc}</p>
                            </div>
                        </ScrollReveal>
                    ))}
                </div>
            </div>
        </section>
    );
}
