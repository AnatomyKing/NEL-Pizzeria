using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("bestelregel_ingredient")]
    public class BestelregelIngredient
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [ForeignKey("Bestelregel")]
        [Column("bestelregel_id", TypeName = "BIGINT UNSIGNED")]
        public long BestelregelId { get; set; }
        public virtual Bestelregel? Bestelregel { get; set; }

        [ForeignKey("Ingredient")]
        [Column("ingredient_id", TypeName = "BIGINT UNSIGNED")]
        public long IngredientId { get; set; }
        public virtual Ingredient? Ingredient { get; set; }

        [Column("quantity", TypeName = "INT")]
        public int Quantity { get; set; } = 1;
    }
}