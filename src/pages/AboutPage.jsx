import team from '../data/team.json';
import SectionHeader from '../components/ui/SectionHeader';
import ScrollReveal from '../components/ui/ScrollReveal';
import TeamMemberCard from '../components/about/TeamMemberCard';
import Values from '../components/about/Values';
import CtaSection from '../components/home/CtaSection';
import pageStyles from '../styles/PageHeader.module.css';

export default function AboutPage() {
    return (
        <>
            <section className={pageStyles.pageHeader}>
                <div className="container">
                    <ScrollReveal>
                        <h1>About Seeda</h1>
                        <p>
                            We're a team of engineers, designers, and strategists on a mission to
                            help businesses grow through technology.
                        </p>
                    </ScrollReveal>
                </div>
            </section>

            {/* Mission */}
            <section className="section">
                <div className="container" style={{ maxWidth: '720px' }}>
                    <ScrollReveal>
                        <div style={{ textAlign: 'center' }}>
                            <h2 style={{ marginBottom: 'var(--space-lg)' }}>Our Story</h2>
                            <p style={{ fontSize: 'var(--font-size-lg)', color: 'var(--neutral-600)', lineHeight: 1.8 }}>
                                Seeda was founded on a simple belief: <strong>great software starts with great relationships</strong>.
                                We partner closely with our clients to understand their challenges, then design and build solutions
                                that are not just technically excellent — but transformative for their business.
                            </p>
                            <p style={{ fontSize: 'var(--font-size-lg)', color: 'var(--neutral-600)', lineHeight: 1.8 }}>
                                Our name comes from the idea of <strong>planting seeds</strong>. Every project we take on is a seed —
                                nurtured with precision, expertise, and care — that grows into lasting impact for the organizations
                                and people we serve.
                            </p>
                        </div>
                    </ScrollReveal>
                </div>
            </section>

            {/* Values */}
            <Values />

            {/* Team */}
            <section className="section">
                <div className="container">
                    <ScrollReveal>
                        <SectionHeader
                            label="Our Team"
                            title="Meet the People Behind Seeda"
                            subtitle="A diverse group of experts united by a passion for building exceptional software."
                        />
                    </ScrollReveal>
                    <div className="grid grid--3">
                        {team.map((member, i) => (
                            <ScrollReveal key={member.id} className="zoom-in" delay={(i % 3) + 1}>
                                <TeamMemberCard member={member} index={i} />
                            </ScrollReveal>
                        ))}
                    </div>
                </div>
            </section>

            <CtaSection />
        </>
    );
}
