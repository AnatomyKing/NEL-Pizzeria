using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("pizzas")]
    public class Pizza
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("naam", TypeName = "VARCHAR(255)")]
        public string Naam { get; set; } = string.Empty;

        public virtual ICollection<IngredientPizza> Ingredienten { get; set; } = new HashSet<IngredientPizza>();
    }
}
