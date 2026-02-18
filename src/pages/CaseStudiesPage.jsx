import { useState } from 'react';
import caseStudies from '../data/caseStudies.json';
import CaseStudyCard from '../components/caseStudies/CaseStudyCard';
import ScrollReveal from '../components/ui/ScrollReveal';
import CtaSection from '../components/home/CtaSection';
import pageStyles from '../styles/PageHeader.module.css';

const CATEGORIES = ['All', ...new Set(caseStudies.map((s) => s.category))];

export default function CaseStudiesPage() {
    const [activeCategory, setActiveCategory] = useState('All');

    const filtered =
        activeCategory === 'All'
            ? caseStudies
            : caseStudies.filter((s) => s.category === activeCategory);

    return (
        <>
            <section className={pageStyles.pageHeader}>
                <div className="container">
                    <ScrollReveal>
                        <h1>Case Studies</h1>
                        <p>
                            Real projects, real results. Explore how we've helped companies
                            solve complex challenges with technology.
                        </p>
                    </ScrollReveal>
                </div>
            </section>

            <section className="section">
                <div className="container">
                    {/* Filter tabs */}
                    <ScrollReveal>
                        <div style={{
                            display: 'flex',
                            gap: '0.5rem',
                            flexWrap: 'wrap',
                            justifyContent: 'center',
                            marginBottom: 'var(--space-3xl)',
                        }}>
                            {CATEGORIES.map((cat) => (
                                <button
                                    key={cat}
                                    onClick={() => setActiveCategory(cat)}
                                    style={{
                                        padding: '0.5rem 1.25rem',
                                        borderRadius: '100px',
                                        fontSize: 'var(--font-size-sm)',
                                        fontWeight: 500,
                                        background: activeCategory === cat ? 'var(--primary)' : 'var(--neutral-100)',
                                        color: activeCategory === cat ? 'var(--white)' : 'var(--neutral-600)',
                                        border: 'none',
                                        cursor: 'pointer',
                                        transition: 'all 0.2s ease',
                                    }}
                                >
                                    {cat}
                                </button>
                            ))}
                        </div>
                    </ScrollReveal>

                    {/* Cards grid */}
                    <div className="grid grid--2">
                        {filtered.map((study, i) => (
                            <ScrollReveal key={study.id} className="zoom-in" delay={(i % 2) + 1}>
                                <CaseStudyCard study={study} />
                            </ScrollReveal>
                        ))}
                    </div>
                </div>
            </section>

            <CtaSection />
        </>
    );
}
