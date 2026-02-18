import services from '../data/services.json';
import ServiceCard from '../components/services/ServiceCard';
import ScrollReveal from '../components/ui/ScrollReveal';
import CtaSection from '../components/home/CtaSection';
import pageStyles from '../styles/PageHeader.module.css';

export default function ServicesPage() {
    return (
        <>
            <section className={pageStyles.pageHeader}>
                <div className="container">
                    <ScrollReveal>
                        <h1>Our Services</h1>
                        <p>
                            From strategy to execution, we offer end-to-end technology services
                            designed to accelerate your growth.
                        </p>
                    </ScrollReveal>
                </div>
            </section>

            <section className="section">
                <div className="container">
                    <div className="grid grid--2" style={{ gap: 'var(--space-2xl)' }}>
                        {services.map((service, i) => (
                            <ScrollReveal key={service.id} delay={(i % 2) + 1}>
                                <ServiceCard service={service} />
                            </ScrollReveal>
                        ))}
                    </div>
                </div>
            </section>

            <CtaSection />
        </>
    );
}
