import { TrendingUp } from 'lucide-react';
import Card from '../ui/Card';
import styles from './CaseStudyCard.module.css';

export default function CaseStudyCard({ study }) {
    return (
        <Card className={styles.caseStudyCard}>
            <div className={styles.visual} style={{ background: `linear-gradient(135deg, ${study.color} 0%, ${study.color}cc 100%)` }}>
                <div className={styles.visualPattern}></div>
                <span className={styles.visualText}>{study.title.split('—')[0].trim()}</span>
            </div>
            <div className={styles.body}>
                <span className={styles.category}>{study.category}</span>
                <h3 className={styles.title}>{study.title}</h3>
                <p className={styles.excerpt}>{study.excerpt}</p>
                <div className={styles.tags}>
                    {study.tags.map((tag) => (
                        <span key={tag} className={styles.tag}>{tag}</span>
                    ))}
                </div>
                <div className={styles.results}>
                    {study.results.slice(0, 4).map((result) => (
                        <div key={result} className={styles.result}>
                            <TrendingUp size={12} className={styles.resultIcon} />
                            <span>{result}</span>
                        </div>
                    ))}
                </div>
            </div>
        </Card>
    );
}
