using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("ingredients")]
    public class Ingredient
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("naam", TypeName = "VARCHAR(255)")]
        public string Naam { get; set; } = string.Empty;

        [Column("prijs", TypeName = "DECIMAL(8,2)")]
        public decimal Prijs { get; set; }

        public virtual ICollection<IngredientPizza> Pizzas { get; set; } = new HashSet<IngredientPizza>();
    }
}
