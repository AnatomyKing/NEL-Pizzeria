using System.ComponentModel.DataAnnotations;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("bestelregels")]
    public class Bestelregel
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("aantal", TypeName = "INT")]
        public int Aantal { get; set; }

        [Required]
        [Column("afmeting", TypeName = "ENUM('klein','normaal','groot')")]
        public string Afmeting { get; set; } = PizzaAfmeting.normaal.ToString();

        [ForeignKey("Pizza")]
        [Column("pizza_id", TypeName = "BIGINT UNSIGNED")]
        public long PizzaId { get; set; }
        public virtual Pizza? Pizza { get; set; }

        [ForeignKey("Bestelling")]
        [Column("bestelling_id", TypeName = "BIGINT UNSIGNED")]
        public long BestellingId { get; set; }
        public virtual Bestelling? Bestelling { get; set; }

        public virtual ICollection<BestelregelIngredient> BestelregelIngredients { get; set; } = new HashSet<BestelregelIngredient>();
    }
}
