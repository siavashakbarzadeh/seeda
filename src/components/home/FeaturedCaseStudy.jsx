import caseStudies from '../../data/caseStudies.json';
import SectionHeader from '../ui/SectionHeader';
import Button from '../ui/Button';
import ScrollReveal from '../ui/ScrollReveal';
import styles from './FeaturedCaseStudy.module.css';

export default function FeaturedCaseStudy() {
    const featured = caseStudies[0]; // First case study as featured

    return (
        <section className={`${styles.featured} section--alt`}>
            <div className="container">
                <ScrollReveal>
                    <SectionHeader
                        label="Featured Project"
                        title="Proven Results, Real Impact"
                        subtitle="See how we helped our clients achieve measurable business outcomes through technology."
                    />
                </ScrollReveal>

                <div className={styles.content}>
                    <ScrollReveal className="fade-in-left">
                        <div className={styles.visual}>
                            <div className={styles.visualInner}>
                                <div className={styles.visualPattern}></div>
                                <span className={styles.visualText}>{featured.title.split('—')[0].trim()}</span>
                            </div>
                        </div>
                    </ScrollReveal>

                    <ScrollReveal className="fade-in-right">
                        <div>
                            <span className={styles.category}>{featured.category}</span>
                            <h3 className={styles.title}>{featured.title}</h3>
                            <p className={styles.excerpt}>{featured.excerpt}</p>
                            <div className={styles.tags}>
                                {featured.tags.map((tag) => (
                                    <span key={tag} className={styles.tag}>{tag}</span>
                                ))}
                            </div>
                            <Button to="/case-studies">
                                View All Case Studies
                            </Button>
                        </div>
                    </ScrollReveal>
                </div>
            </div>
        </section>
    );
}
